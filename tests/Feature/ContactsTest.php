<?php

namespace Tests\Feature;
use Tests\TestCase;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use App\Contact;
use Carbon\Carbon;

class ContactsTest extends TestCase
{
	use RefreshDatabase;

    /**  @test */
    public function a_contact_can_be_added()
    {
        $response = $this->post('/api/contacts', $this->data());

        $contact = Contact::first();

        // $this->assertCount(1, $contact);
        $this->assertEquals('Test Name', $contact->name);
        $this->assertEquals('test@email.com', $contact->email);
        $this->assertEquals('05/14/1988', $contact->birthday->format('m/d/Y'));
        $this->assertEquals('ABC String', $contact->company);
    }

    /**  @test */
    public function email_must_be_a_valid_email(){
       $response = $this->post('/api/contacts', array_merge($this->data(), ['email' => 'NOT AN EMAIL ']));

        $contact = Contact::first();

        $response->assertSessionHasErrors('email');
        $this->assertCount(0, Contact::all());
    }


    /**  @test */
    public function birthdays_are_properly_stored(){
        $this->withoutExceptionHandling();
        $response = $this->post('/api/contacts', array_merge($this->data()));

        $contact = Contact::first();

        // $response->assertSessionHasErrors('email');
        $this->assertCount(1, Contact::all());
        $this->assertInstanceOf(Carbon::class, Contact::first()->birthday);
        $this->assertEquals('05-14-1988', Contact::first()->birthday->format('m-d-Y'));
    }

      /**  @test */
    public function a_contact_can_be_retrieved(){
        $contact = factory(Contact::class)->create();
        $response = $this->get('/api/contacts/' . $contact->id);

        // dd($contact);
        $response->assertJson([
            'name' => $contact->name,
            'email' => $contact->email,
            'birthday' => $contact->birthday,
            'company' => $contact->company,
        ]);
    }

    /**  @test */
    public function a_contact_can_be_patched(){
        $this->withoutExceptionHandling();

        $contact = factory(Contact::class)->create();
        $testData = $this->data();
        $response = $this->patch('/api/contacts/' . $contact->id, $testData);

        // Get an updated version
        $contact = $contact->fresh();

        $this->assertEquals('Test Name', $contact->name);
        $this->assertEquals('test@email.com', $contact->email);
        $this->assertEquals('05/14/1988', $contact->birthday->format('m/d/Y'));
        $this->assertEquals('ABC String', $contact->company);
    }

    /**  @test */
    public function fields_are_required(){
        collect(['name', 'email', 'birthday', 'company'])
            ->each(function($field){
                $response = $this->post('/api/contacts', array_merge($this->data(), [$field => '']));

                $contact = Contact::first();

                $response->assertSessionHasErrors($field);
                $this->assertCount(0, Contact::all());
            });
    }


    private function data(){
        return [
            'name' => 'Test Name',
            'email' => 'test@email.com',
            'birthday' => '05/14/1988',
            'company' => 'ABC String'
            ];
    }
}
