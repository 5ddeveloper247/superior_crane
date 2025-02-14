<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Artisan;
use Illuminate\Support\Facades\Auth;

use App\Exports\ArchiveJobsExport;
use App\Exports\ArchiveRiggerTicketsExport;
use App\Exports\ArchiveTransportationTicketsExport;
use App\Exports\ArchivePayDutyFormsExport;
use Maatwebsite\Excel\Facades\Excel;

use Carbon\Carbon;
use App\Models\User;
use App\Models\JobModel;
use App\Models\JobImages;
use App\Models\ArchiveJob;

use App\Models\RiggerTicket;
use App\Models\RiggerTicketImages;
use App\Models\ArchiveRiggerTicket;

use App\Models\TransportationTicketModel;
use App\Models\TransportationTicketImages;
use App\Models\ArchiveTransportationTicket;

use App\Models\PayDutyModel;
use App\Models\PayDutytImages;
use App\Models\ArchivePayDutyForm;

use App\Models\ArchiveService;
use Illuminate\Support\Facades\Storage;

use ZipArchive;
// use File;
use File;

use Zip;

class ServiceController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    
    // Use dependency injection to bring in the PaymentEncode class
    public function __construct()
    {
        
    }

    public function index(Request $request)
    {
        
        $pending_services = ArchiveService::where('status', '0')
                                            ->where('processing_code', null)
                                            ->orderBy('id', 'asc')
                                            ->limit('1')->get();
        
        if($pending_services){
            foreach($pending_services as $service){
                
                $processingCode = date('YmdHis');
                $service->status = '1'; // 0:pending, 1:inprocess, 2:completed, 3:cancelled	
                $service->processing_code = $processingCode;
                $service->save();

                $result = false;

                if($service->module == 'JOB'){
                    
                    $result = $this->moveArchiveJobs($service);
                    
                }
                
                if($service->module == 'RIGGER TICKET'){
                    
                    $result = $this->moveArchiveRiggerTickets($service);
                    
                }

                if($service->module == 'TRANSPORT TICKET'){
                    
                    $result = $this->moveArchiveTransportatonTickets($service);
                    
                }

                if($service->module == 'PAY DUTY FORM'){
                    
                    $result = $this->moveArchivePayDutyForms($service);
                    
                }

                if($result){    //  if service result status is true then update service status
                    $service->status = '2'; // 0:pending, 1:inprocess, 2:completed, 3:cancelled	
                    $service->save();
                }
            }
        }
        return true;
    }

    public function moveArchiveJobs($service=null){
        
        if($service){
            $service_id = $service->id;
            $from_date = $service->from_date;
            $to_date = $service->to_date;

            $jobs = JobModel::whereDate('date', '>=', $from_date)
                            ->whereDate('date', '<=', $to_date)
                            ->with('jobImages')
                            ->get();
            
            if (!$jobs->isEmpty()) { // Check if there are jobs to archive
                $ArchiveJob = new ArchiveJob();
                $ArchiveJob->service_id = $service_id;
                $ArchiveJob->json_data = json_encode($jobs);
                $ArchiveJob->created_at = now();
                $ArchiveJob->updated_at = now();
                $ArchiveJob->save();
            
                // Delete job images before deleting jobs
                foreach ($jobs as $job) {
                    JobImages::where('job_id', $job->id)->delete();
                    JobModel::where('id', $job->id)->delete();
                }
            } else {
                // Archive empty job list if no jobs found
                ArchiveJob::create([
                    'service_id' => $service_id,
                    'json_data' => json_encode([]),
                    'created_at' => now(),
                    'updated_at' => now(),
                ]);
            }
        }
        return true;
    }

    public function moveArchiveRiggerTickets($service=null){

        if($service){
            $service_id = $service->id;
            $from_date = $service->from_date;
            $to_date = $service->to_date;

            $tickets = RiggerTicket::whereDate('date', '>=', $from_date)
                                    ->whereDate('date', '<=', $to_date)
                                    ->with('ticketImages')
                                    ->get();
            
            if (!$tickets->isEmpty()) { // Check if there are ticket to archive
                $ArchiveTicket = new ArchiveRiggerTicket();
                $ArchiveTicket->service_id = $service_id;
                $ArchiveTicket->json_data = json_encode($tickets);
                $ArchiveTicket->created_at = now();
                $ArchiveTicket->updated_at = now();
                $ArchiveTicket->save();
            
                // Delete ticket images before deleting ticket
                foreach($tickets as $ticket){
                    RiggerTicketImages::where('ticket_id', $ticket->id)->delete();
                    RiggerTicket::where('id', $ticket->id)->delete();
                }
            } else {
                // Archive empty ticket list if no ticket found
                ArchiveRiggerTicket::create([
                    'service_id' => $service_id,
                    'json_data' => json_encode([]),
                    'created_at' => now(),
                    'updated_at' => now(),
                ]);
            }
        }
        return true;
    }

    public function moveArchiveTransportatonTickets($service=null){

        if($service){
            $service_id = $service->id;
            $from_date = $service->from_date;
            $to_date = $service->to_date;

            $tickets = TransportationTicketModel::whereDate('created_at', '>=', $from_date)
                                    ->whereDate('created_at', '<=', $to_date)
                                    ->with('ticketImages')
                                    ->get();
            
            if (!$tickets->isEmpty()) { // Check if there are tickets to archive
                $ArchiveTicket = new ArchiveTransportationTicket();
                $ArchiveTicket->service_id = $service_id;
                $ArchiveTicket->json_data = json_encode($tickets);
                $ArchiveTicket->created_at = now();
                $ArchiveTicket->updated_at = now();
                $ArchiveTicket->save();
            
                // Delete ticket images before deleting records
                foreach($tickets as $ticket){
                    TransportationTicketImages::where('ticket_id', $ticket->id)->delete();
                    TransportationTicketModel::where('id', $ticket->id)->delete();
                }
            } else {
                // Archive empty tickets list if no record found
                ArchiveTransportationTicket::create([
                    'service_id' => $service_id,
                    'json_data' => json_encode([]),
                    'created_at' => now(),
                    'updated_at' => now(),
                ]);
            }
        }
        return true;
    }

    public function moveArchivePayDutyForms($service=null){

        if($service){
            $service_id = $service->id;
            $from_date = $service->from_date;
            $to_date = $service->to_date;

            $payDutyForms = PayDutyModel::whereDate('date', '>=', $from_date)
                                    ->whereDate('date', '<=', $to_date)
                                    ->with('dutyImages')
                                    ->get();
            
            if (!$payDutyForms->isEmpty()) {
                $ArchivePayDuty = new ArchivePayDutyForm();
                $ArchivePayDuty->service_id = $service_id;
                $ArchivePayDuty->json_data = json_encode($payDutyForms);
                $ArchivePayDuty->created_at = now();
                $ArchivePayDuty->updated_at = now();
                $ArchivePayDuty->save();
            
                foreach($payDutyForms as $form){
                    PayDutytImages::where('pay_duty_id', $form->id)->delete();
                    PayDutyModel::where('id', $form->id)->delete();
                }
            } else {
               
                ArchivePayDutyForm::create([
                    'service_id' => $service_id,
                    'json_data' => json_encode([]),
                    'created_at' => now(),
                    'updated_at' => now(),
                ]);
            }
        }
        return true;
    }


    public function exportArchiveJobs($serviceId)
    {
        $service = ArchiveService::where('id', $serviceId)->first();

        
        if($service){

            if($service->module == 'JOB'){
                
                $archiveJob = ArchiveJob::where('service_id', $serviceId)->first();
        
                if (!$archiveJob) {
                    return response()->json(['message' => 'No data found for this service'], 404);
                }

                $jsonData = json_decode($archiveJob->json_data, true);  // Assuming 'json_data' is the column that stores your JSON
                // $dummyFolder = public_path("service_images");
                
                // if (!file_exists($dummyFolder)) {
                //     mkdir($dummyFolder, 0777, true);
                // }

                // if($jsonData){
                //     foreach($jsonData as $job){
                       
                //         $jobImagesPath = $dummyFolder . '/' . $serviceId . '/job';
                //         $jobImagesPath .= '/' . $job['id'];

                //         if (!file_exists($jobImagesPath)) {
                //             mkdir($jobImagesPath, 0777, true);
                //         }
                //         $jobImages = $job['job_images'];

                //         foreach($jobImages as $image){
                //             if (isset($image['path'])) {
                //                 $cleanedPath = preg_replace('/^public\//', '', $image['path']);
                //                 $cleanedPath = str_replace("/public","",$image['path']);
                                
                //                 $imagePath = public_path($cleanedPath);
                               
                //                 $destinationPath = $jobImagesPath . '/' . basename($image['path']);
                //                 if (file_exists($imagePath)) {
                //                     copy($imagePath, $destinationPath);
                //                 }
                //             }
                //         }
                //     }
                    
                    
                // }
                
                // $zipFilePath = $this->createZip($dummyFolder);
                // $zipUrl = url('public/' . basename($zipFilePath));
                // dd($zipUrl);
                
                
                return Excel::download(new ArchiveJobsExport($jsonData), 'archive_jobs.xlsx');

            }else 

            if($service->module == 'RIGGER TICKET'){
                
                $archiveTicket = ArchiveRiggerTicket::where('service_id', $serviceId)->first();
                
                if (!$archiveTicket) {
                    return response()->json(['message' => 'No data found for this service'], 404);
                }

                $jsonData = json_decode($archiveTicket->json_data, true);  // Assuming 'json_data' is the column that stores your JSON
                
                return Excel::download(new ArchiveRiggerTicketsExport($jsonData), 'archive_rigger_tickets.xlsx');

            }else 

            if($service->module == 'TRANSPORT TICKET'){
                
                $archiveTicket = ArchiveTransportationTicket::where('service_id', $serviceId)->first();
                
                if (!$archiveTicket) {
                    return response()->json(['message' => 'No data found for this service'], 404);
                }

                $jsonData = json_decode($archiveTicket->json_data, true);  // Assuming 'json_data' is the column that stores your JSON
                
                return Excel::download(new ArchiveTransportationTicketsExport($jsonData), 'archive_transportation_tickets.xlsx');

            }else 

            if($service->module == 'PAY DUTY FORM'){
                
                $archiveForms = ArchivePayDutyForm::where('service_id', $serviceId)->first();
                
                if (!$archiveForms) {
                    return response()->json(['message' => 'No data found for this service'], 404);
                }

                $jsonData = json_decode($archiveForms->json_data, true);  // Assuming 'json_data' is the column that stores your JSON
                
                return Excel::download(new ArchivePayDutyFormsExport($jsonData), 'archive_pay_duty_forms.xlsx');

            }
        }else{
            return response()->json(['message' => 'Something went wrong...'], 404);
        }
    }

    private function createZip($dummyFolder)
    {
        $zipFileName = 'dummy_images.zip';
        $zipFilePath = public_path($zipFileName); // No need for extra "/"

        $zip = new ZipArchive();
        if ($zip->open($zipFilePath, ZipArchive::CREATE | ZipArchive::OVERWRITE) === TRUE) {
            $files = scandir($dummyFolder);

            foreach ($files as $file) {
                $filePath = $dummyFolder . '/' . $file;
                if (is_file($filePath)) {
                    $zip->addFile($filePath, $file);  // Add file to zip
                }
            }

            $zip->close();
            // dd($zipFilePath);
            return $zipFilePath;  // Return the zip file path
        } else {
            throw new \Exception('Failed to create zip file.');
        }
    }

    public function createZip1()
    {
        $dummyFolder = public_path('service_images/5/job/60');
        $zipFileName = 'dummy_images.zip';
        $zipFilePath = public_path($zipFileName); // No need for extra "/"

        $zip = new ZipArchive();
        if ($zip->open($zipFilePath, ZipArchive::CREATE | ZipArchive::OVERWRITE) === TRUE) {
            $files = scandir($dummyFolder);

            foreach ($files as $file) {
                $filePath = $dummyFolder . '/' . $file;
                if (is_file($filePath)) {
                    $zip->addFile($filePath, $file);  // Add file to zip
                }
            }

            $zip->close();
            // dd($zipFilePath);
            // return $zipFilePath;  // Return the zip file path
            return response()->download($zipFilePath);
        } else {
            throw new \Exception('Failed to create zip file.');
        }

        // return Zip::create('zipFileName.zip', File::files(public_path('uploads')));
        // $zipFileName = 'images.zip';
        // $zipFilePath = public_path($zipFileName);
        // $directory = public_path('service_images'); // Folder containing the files to zip
    
        // $zip = new ZipArchive;
        // if ($zip->open($zipFilePath, ZipArchive::CREATE | ZipArchive::OVERWRITE) === TRUE) {
        //     $files = File::files($directory); // Get all files in the directory
            
        //     foreach ($files as $file) {
        //         $zip->addFile($file->getRealPath(), $file->getFilename()); // Add each file to the ZIP
        //     }
        //     $zip->close();
        // } else {
        //     return response()->json(['error' => 'Unable to create ZIP file'], 500);
        // }
    
        // // Return the ZIP file for download
        // return response()->download($zipFilePath)->deleteFileAfterSend(true);

        // $folderName = 'service_images'; // Folder name inside public/
        // $folderPath = public_path($folderName);
        // $gzFilePath = storage_path("app/public/{$folderName}.tar.gz");

        // // Ensure folder exists
        // if (!is_dir($folderPath)) {
        //     return response()->json(['error' => 'Folder not found'], 404);
        // }

        // // Use Symfony Process to execute tar command
        // $process = new Process(["tar", "-czvf", $gzFilePath, "-C", public_path(), $folderName]);
        // $process->run();

        // // Check for errors
        // if (!$process->isSuccessful()) {
        //     throw new ProcessFailedException($process);
        // }

        // // Return the compressed file as a download response
        // return response()->download($gzFilePath)->deleteFileAfterSend(true);
    
    }

    // public function downloadFolder()
    // {
    //     // Define the folder path
    //     $folderPath = public_path('service_images'); // Change this to your folder path

    //     // Define the output .tar.gz file name
    //     $tarGzFileName = 'folder.tar.gz';
    //     $tarGzFilePath = storage_path('app/' . $tarGzFileName);

    //     // Create a .tar archive
    //     $tarFileName = 'folder.tar';
    //     $tarFilePath = storage_path('app/' . $tarFileName);

    //     // Open the tar file for writing
    //     $tarFile = fopen($tarFilePath, 'w');

    //     if (!$tarFile) {
    //         return "Failed to create tar file.";
    //     }

    //     // Add files to the tar archive
    //     $this->addFolderToTar($folderPath, $tarFile, '');

    //     // Close the tar file
    //     fclose($tarFile);

    //     // Compress the tar file into .tar.gz
    //     $this->compressTarToGz($tarFilePath, $tarGzFilePath);

    //     // Check if the .tar.gz file was created
    //     if (file_exists($tarGzFilePath)) {
    //         // Download the .tar.gz file
    //         return response()->download($tarGzFilePath)->deleteFileAfterSend(true);
    //     } else {
    //         return "Failed to create .tar.gz file.";
    //     }
    // }

    // /**
    //  * Recursively add files and folders to the tar archive.
    //  */
    // private function addFolderToTar($folderPath, $tarFile, $basePath)
    // {
    //     $files = scandir($folderPath);

    //     foreach ($files as $file) {
    //         if ($file === '.' || $file === '..') {
    //             continue;
    //         }

    //         $filePath = $folderPath . '/' . $file;
    //         $relativePath = $basePath . '/' . $file;

    //         if (is_dir($filePath)) {
    //             // Add directory entry to the tar archive
    //             $this->addFolderToTar($filePath, $tarFile, $relativePath);
    //         } else {
    //             // Add file entry to the tar archive
    //             $fileContent = file_get_contents($filePath);
    //             $header = $this->createTarHeader($relativePath, strlen($fileContent));
    //             fwrite($tarFile, $header);
    //             fwrite($tarFile, $fileContent);
    //             fwrite($tarFile, str_repeat("\0", 512 - (strlen($fileContent) % 512)));
    //         }
    //     }
    // }

    // /**
    //  * Create a tar header for a file.
    //  */
    // private function createTarHeader($fileName, $fileSize)
    // {
    //     $header = str_pad($fileName, 100, "\0"); // File name
    //     $header .= str_pad(decoct($fileSize), 12, "\0", STR_PAD_LEFT); // File size
    //     $header .= str_pad(decoct(fileperms($fileName)), 12, "\0", STR_PAD_LEFT); // File permissions
    //     $header .= str_pad(decoct(filemtime($fileName)), 12, "\0", STR_PAD_LEFT); // Modification time
    //     $header .= str_repeat("\0", 8); // Checksum (placeholder)
    //     $header .= '0'; // Type flag (regular file)
    //     $header .= str_repeat("\0", 100); // Link name
    //     $header .= str_repeat("\0", 8); // Magic and version
    //     $header .= str_pad('', 32, "\0"); // User and group info
    //     $header .= str_pad('', 167, "\0"); // Padding
    //     $header .= str_pad(decoct($this->calculateTarChecksum($header)), 8, "\0", STR_PAD_LEFT); // Checksum
    //     $header .= str_repeat("\0", 12); // Padding

    //     return $header;
    // }

    // /**
    //  * Calculate the checksum for the tar header.
    //  */
    // private function calculateTarChecksum($header)
    // {
    //     $checksum = 0;
    //     for ($i = 0; $i < 512; $i++) {
    //         $checksum += ord($header[$i]);
    //     }
    //     return $checksum;
    // }

    // /**
    //  * Compress a tar file into a .tar.gz file.
    //  */
    // private function compressTarToGz($tarFilePath, $tarGzFilePath)
    // {
    //     $tarContent = file_get_contents($tarFilePath);
    //     $gzContent = gzencode($tarContent, 9); // Compress with maximum compression level
    //     file_put_contents($tarGzFilePath, $gzContent);
    // }
}