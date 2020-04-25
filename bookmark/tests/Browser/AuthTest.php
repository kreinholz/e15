<?php

namespace Tests\Browser;

use Illuminate\Foundation\Testing\DatabaseMigrations;
use Laravel\Dusk\Browser;
use Tests\DuskTestCase;

class AuthTest extends DuskTestCase
{
    use DatabaseMigrations;

    /**
     * A Dusk test example.
     *
     * @return void
     */
    public function testRegistration()
    {
        $this->browse(function (Browser $browser) {
            $browser->visit('/')
                    ->click('@register-link')
                    ->assertSee('Register')
                    ->assertVisible('@register-heading')
                    ->type('@name-input', 'Joe Smith')
                    ->type('@email-input', 'joe@gmail.com')
                    ->type('@password-input', 'helloworld')
                    ->type('@password-confirm-input', 'helloworld')
                    ->click('@register-button')
                    ->assertSee('Joe Smith');
        });
    }

    public function testFailedRegistration()
    {
        $this->browse(function (Browser $browser) {
            $browser->logout()
                    ->visit('/register')
                    ->type('name', 'Joe Smith')
                    ->type('email', 'joe1@gmail.com')
                    ->type('password', 'hello')
                    ->type('password_confirmation', 'hello')
                    ->click('@register-button')
                    ->assertSee('The password must be at least 8 characters.');
        });
    }

    /**
     *
     */
    public function testLogin()
    {
        $this->seed();

        $this->browse(function (Browser $browser) {
            $browser->logout()
                    ->visit('/login')
                    ->type('@email-input', 'jill@harvard.edu')
                    ->type('@password-input', 'helloworld')
                    ->click('@login-button')
                    ->assertSee('LOGOUT JILL HARVARD');
        });
    }
}
