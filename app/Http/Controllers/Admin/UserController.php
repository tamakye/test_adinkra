<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;

class UserController extends Controller
{

	public function index(){

		$users = User::latest()->get();

		return view('admin.users.index', compact('users'));
	}

	public function create(){

		if (session()->has('csv_data')) {
			session()->forget('csv_data');
		}

		return view('admin.users.create');
	}


	public function processImport(Request $request){

		$request->validate([
			'csv_file' => ['required', 'file', 'max:10240'],
		]);

		if (strtolower($request->file('csv_file')->getClientOriginalExtension()) != 'csv') {
			return  back()->withInput()->withErors(['csv_file' => 'The file is not supported. Only .csv file is allowed']);
		}

		$path = $request->file('csv_file')->getRealPath();

		// get records from csv
		$data = array_map('str_getcsv', file($path));

		
		// check if records exceeds 1000
		if (count($data) > 1001) {
			\Session::flash('info', 'CSV file contains '. (count($data) - 1001). ' records. Only 1000 records can be uploaded at time');
			return back();
		}

		// fetch all emails and phone in array
		// $emails = [];
		// $phones = [];
		// foreach ($data as $key => $object) {
		// 	if ($key == 0) continue;

		// 	$emails[] = [$key, $object[2]];
		// 	$phones[] = [$key, $object[3]];
		// }

		// check for duplicates
		// $uniques = [];
		// $duplicates = [];
		// $duplicates_found = [];
		// foreach ($records as $line => $item) {

		// 	if (in_array($item[0], $duplicates) || in_array($item[1], $duplicates) || in_array($item[0], $uniques) || in_array($item[1], $uniques)){
		// 		$duplicates[] = $item;
		// 		$duplicates_found[] = $item;
		// 	}else{
		// 		$uniques[] = $item;
		// 		$uniques[] = $item;
		// 	}

		// 	return [
		// 		'uniques' => $uniques,
		// 		'duplicates' => $duplicates,
		// 		'duplicates_found' => $duplicates_found,
		// 	];

		// }

		// return [
		// 	'uniques' => $uniques,
		// 	'duplicates' => $duplicates,
		// 	'duplicates_found' => $duplicates_found,
		// ];

		// unique emails and phone
		// $uniqueEmails = array_unique($emails[1]);
		// $uniquePhones = array_unique($phones[1]);
		// // dd($uniquePhones);

		// // find dubplicates
		// $duplicateEmails = array_diff_assoc($emails, $uniqueEmails);
		// $duplicatePhones = array_diff_assoc($phones, $uniquePhones);

		// return [
		// 	'emails' => $emails,
		// 	'phones' => $phones,
		// 	'uniqueEmails' => $uniqueEmails,
		// 	'uniquePhones' => $uniquePhones,
		// 	'duplicateEmails' => $duplicateEmails,
		// 	'duplicatePhones' => $duplicatePhones,
		// ];

        // process csv file
		return $this->process_csv($request, $data);
	}

	/**
     * process the csv file
     *
     * @param      <type>  $request  The request
     *
     * @return     <type>  ( description_of_the_return_value )
     */
	public function process_csv($request, $data){

		if (count($data) > 1) {
			$csv_data = array_slice($data, 1, 5);

			$session_data =  [

				'csv_filename' => $request->file('csv_file')->getClientOriginalName(),
				'csv_data' => json_encode($data),
			];

			$request->session()->put('csv_data',  $session_data);



		}else{

			\Session::flash('info', 'No records found in CSV file');
			return back();
		}

		return view('admin.users.upload-preview', compact('csv_data', 'data'));
	}

	/**
	 * Saves a bulk upload page.
	 *
	 * @param      \Illuminate\Http\Request  $request  The request
	 *
	 * @return     <type>                    ( description_of_the_return_value )
	 */
	public function saveBulkUploadPage(Request $request){

        // get csv data
		$data   = $request->session()->get('csv_data');
        // file name
		$csv_filename = $data['csv_filename'];
        // all records
		$csv_data = json_decode($data['csv_data'], true);
        // declare empty array
		$new_data = [];
		$already_records = [];

        // loop through  all csv record and 
		foreach ($csv_data as $key => $row) { 
            // skip first row which is the header
			if ($key == 0) {
				continue;
			}


			if (!empty($this->emailExist($row[2])) || !empty($this->phoneExist($row[3])) ) {
				$records = [
					'first_name' => $row[0],
					'last_name' => $row[1],
					'email' => $row[2],
					'phone' => $row[3],
				];

				$already_records[]  = $records; 

			}else{
				// push each row into an array
				$data = [
					'slug' => str_pad(rand(11111, 99999), 10, mt_rand(1000000000, 9999999999), STR_PAD_LEFT),
					'first_name' => $row[0],
					'last_name' => $row[1],
					'email' => $row[2],
					'phone' => $row[3],
					'password' => Hash::make($row[2]),
					'email_verified_at' => now(),
					'created_at' => now(),
					'updated_at' => now(),
				];

            // add row data to records
				$new_data[]  = $data; 
			}

		}

		// push old records to array if found.
		if (count($already_records) > 0) {
			$request->session()->put('old_records',  $already_records);
		}

		// dd([
		// 	'duplicate' => $already_records,
		// 	'new' => $new_data,
		// ]);

		if (count($new_data) > 0) {
        	// make a collection to use chunk
			$insert_data = collect($new_data);
        	// chunk in 500
			$chunks = $insert_data->chunk(500);
        	// insert records for the chunk
			foreach ($chunks as $chunk){

				DB::table('users')->insert($chunk->toArray());
			}


        	// clear csv session
			$request->session()->forget('csv_data');

			\Session::flash('success', 'Users imported successfully');

		}

		return redirect()->route('admin.users');

	}


	/**
	 * Check if email exist
	 *
	 * @param      <type>  $email  The email
	 *
	 * @return     <type>  ( description_of_the_return_value )
	 */
	public function emailExist($email){

		return User::where('email', $email)->first();
	}

	/**
	 * check phone exist
	 *
	 * @param      <type>  $phone  The phone
	 *
	 * @return     <type>  ( description_of_the_return_value )
	 */
	public function phoneExist($phone){

		return User::where('phone', $phone)->first();
	}

}
