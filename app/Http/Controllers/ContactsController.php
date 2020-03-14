<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Contact;
use Carbon\Carbon;

class ContactsController extends Controller
{
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
		// dd($this->validateData());
		$contact->update($this->validateData());
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
