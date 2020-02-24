<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use App\Contact;
use Tests\TestCase;

class ContactsTest extends TestCase
{
    /**  @test */
    public function a_contact_can_be_added()
    {
        $response = $this->post('/api/contacts', ['name' => 'Test Name']);

        $response->assertCount(1, Contact::all());
    }
}
