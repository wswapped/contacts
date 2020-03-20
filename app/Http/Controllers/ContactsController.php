<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Contact;
use Carbon\Carbon;

class ContactsController extends Controller
{
	public function index()
	{
		return request()->user()->contacts;
	}
	public function store()
	{

		Contact::create($this->validateData());
	}

	public function show(Contact $contact)
	{
		return $contact;
	}

	public function update(Contact $contact)
	{
		$ret = $contact->update($this->validateData());
	}

	public function destroy(Contact $contact)
	{
		$ret = $contact->delete();
	}

	

	private function validateData(){
		return request()->validate([
			'name' => 'required',
			'email' => 'required|email',
			'birthday' => 'required',
			'company' => 'required',
		]);
	}
}
