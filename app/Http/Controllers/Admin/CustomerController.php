<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Http\Traits\FileUploadTrait;
use Illuminate\Support\Facades\File;
use App\Models\Customer;

class CustomerController extends Controller
{
	use FileUploadTrait;

	public function index()
	{
		$data['customers'] = Customer::orderBy('id','desc')->paginate(20);
		return view('admin.customer.index', $data);
	}
	public function create()
	{
		return view('admin.customer.create');
	}

	public function store(Request $request)
	{
		$request->validate([
			'first_name' => 'required',
			'last_name' => 'required',
			'username' => 'nullable',
			'email' => 'required',
			'password' => 'required',
			'phone_number' => 'required',
			'address' => 'nullable',
			'city' => 'nullable',
			'zip_code' => 'nullable',
			'state' => 'nullable',
			'country' => 'required',
			'email_verify' => 'nullable',
			'sms_verify' => 'nullable',
			'image' => 'nullable',
		]);

		$customer = new Customer();
		$customer->first_name = $request->first_name;
		$customer->last_name = $request->last_name;
		$customer->username = $request->username;
		$customer->email = $request->email;
		$customer->password = $request->password;
		$customer->phone_number = $request->phone_number;
		$customer->address = $request->address;
		$customer->city = $request->city;
		$customer->zip_code = $request->zip_code;
		$customer->state = $request->state;
		$customer->country = $request->country;
		$customer->email_verify = $request->email_verify;
		$customer->sms_verify = $request->sms_verify;
		if ($request->hasFile('image')) {
			try {
				$imageData = [
					'file' => $request->image,
					'path' => 'assets/images/customers/',
					'size' => '1920x1100',
					'prevFile' => null,
				];
				$image = $this->uploadFile('image', $imageData);
			} catch (Exception $e) {
				$alert = ['danger','Something went wrong.'];
				return back()->withAlert($alert);
			}
		}
		$customer->image =  $image;
		$customer->save();

		$alert = ['success', 'Customer created successfully'];
		return back()->withAlert($alert);
	}

	public function edit($id)
	{
		$data['customer'] = Customer::where('id', $id)->firstOrFail();
		return view('admin.customer.edit', $data);
	}

	public function update(Request $request, $id)
	{
		$request->validate([
			'first_name' => 'required',
			'last_name' => 'required',
			'username' => 'nullable',
			'email' => 'required',
			'password' => 'required',
			'phone_number' => 'required',
			'address' => 'nullable',
			'city' => 'nullable',
			'zip_code' => 'nullable',
			'state' => 'nullable',
			'country' => 'required',
			'email_verify' => 'nullable',
			'sms_verify' => 'nullable',
			'image' => 'nullable',
		]);

		$customer = Customer::findOrFail($id);
		$customer->first_name = $request->first_name;
		$customer->last_name = $request->last_name;
		$customer->username = $request->username;
		$customer->email = $request->email;
		$customer->password = $request->password;
		$customer->phone_number = $request->phone_number;
		$customer->address = $request->address;
		$customer->city = $request->city;
		$customer->zip_code = $request->zip_code;
		$customer->state = $request->state;
		$customer->country = $request->country;
		$customer->email_verify = $request->email_verify;
		$customer->sms_verify = $request->sms_verify;
		$image = $customer->image;
		if ($request->hasFile('image')) {
			try {
				$imageData = [
					'file' => $request->image,
					'path' => 'assets/images/customers/',
					'size' => '1920x1100',
					'prevFile' => $customer->image,
				];
				$image = $this->uploadFile('image', $imageData);
			} catch (Exception $e) {
				$alert = ['danger','Something went wrong.'];
				return back()->withAlert($alert);
			}
		}
		$customer->image =  $image;
		$customer->save();

		$alert = ['success', 'Customer updated successfully'];
		return back()->withAlert($alert);
	}

	public function enable(Request $request)
	{
		$customer = Customer::findOrFail($request->id);
		$customer->status = 1;
		$customer->save();

		$alert = ['success', 'Customer enable successfully'];
		return back()->withAlert($alert);
	}

	public function disable(Request $request)
	{
		$customer = Customer::findOrFail($request->id);
		$customer->status = 0;
		$customer->save();

		$alert = ['success', 'Customer disable successfully'];
		return back()->withAlert($alert);
	}

	public function delete($id)
	{
		$customer = Customer::findOrFail($id);
		$customer->delete();

		$alert = ['success', 'Customer deleted successfully'];
		return back()->withAlert($alert);
	}

}