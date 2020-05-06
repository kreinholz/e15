<?php

namespace Tests\Browser;

use Illuminate\Foundation\Testing\DatabaseMigrations;
use Laravel\Dusk\Browser;
use Tests\DuskTestCase;

class AuthTest extends DuskTestCase
{
    use DatabaseMigrations;

    /**
     * Run our database seeds so we have test data to work with
     * Ref: https://www.5balloons.info/migrating-and-seeding-database-in-laravel-dusk/
     * Make sure it returns void, ref: https://github.com/spatie/laravel-activitylog/issues/486
     */
    public function setUp(): void
    {
        parent::setUp();
        $this->artisan('db:seed');
    }

    /* Between Auth related tests, we don't just want to logout(), we want to deleteAllCookies() to
    ensure we're working with a clear session. Hence, the method ->driver->manage()->deleteAllCookies()
    will be added to the end of applicable tests. Ref: https://github.com/laravel/dusk/issues/100 */

    /**
     * A Dusk test to visit the root of the application.
     *
     * @return void
     */
    public function testVisitHome()
    {
        $this->browse(function (Browser $browser) {
            $browser->visit('/')
                ->assertSeeLink('login');
        });
    }
    /**
     * A Dusk test of route protection.
     *
     * @return void
     */
    public function testAuthRequired()
    {
        $this->browse(function (Browser $browser) {
            $browser->visit('/checklists')
                ->assertSee('Login');
        });
    }
    /**
     * A Dusk test of successful new user registration.
     *
     * @return void
     */
    public function testRegistrationSuccess()
    {
        $this->browse(function (Browser $browser) {
            $browser->visit('/register')
                ->type('first_name', 'John')
                ->type('last_name', 'Harvard')
                ->type('email', 'john@harvard.edu')
                ->type('password', 'helloworld')
                ->type('password_confirmation', 'helloworld')
                ->press('Register')
                ->assertSee('Welcome back, John Harvard.')
                ->driver->manage()->deleteAllCookies();
        });
    }
    /**
     * A Dusk test of an unsuccessful user registration.
     *
     * @return void
     */
    public function testRegistrationFailure()
    {
        $this->browse(function (Browser $browser) {
            $browser->logout()
                ->visit('/register')
                ->type('first_name', 'John')
                ->type('last_name', 'Harvard')
                ->type('email', 'jill@harvard.edu')
                ->type('password', 'helloworld')
                ->type('password_confirmation', 'helloworld')
                ->press('Register')
                ->assertVisible('.alert')
                ->assertSee('The email has already been taken.')
                ->driver->manage()->deleteAllCookies();
        });
    }
    /**
     * A Dusk test of a successful login by the Safety Oversight Manager.
     *
     * @return void
     */
    public function testLoginSuccessSafetyOversightManager()
    {
        $this->browse(function (Browser $browser) {
            $browser->logout()
                ->visit('/login')
                ->type('email', 'jill@harvard.edu')
                ->type('password', 'helloworld')
                ->press('Login')
                ->assertSee('Welcome back, Jill Harvard.')
                ->assertSee('create new checklists.')
                ->driver->manage()->deleteAllCookies();
        });
    }
    /**
     * A Dusk test of a successful login by a regular user.
     *
     * @return void
     */
    public function testLoginSuccessRegularUser()
    {
        $this->browse(function (Browser $browser) {
            $browser->logout()
                ->visit('/login')
                ->type('email', 'jamal@harvard.edu')
                ->type('password', 'helloworld')
                ->press('Login')
                ->assertSee('Welcome back, Jamal Harvard.')
                ->assertDontSee('create new checklists.')
                ->driver->manage()->deleteAllCookies();
        });
    }
    /**
     * A Dusk test of an unsuccessful login.
     *
     * @return void
     */
    public function testLoginFailure()
    {
        $this->browse(function (Browser $browser) {
            $browser->logout()
                ->visit('/login')
                ->type('email', 'jamal@harvard.edu')
                ->type('password', '12345678')
                ->press('Login')
                ->assertVisible('.alert')
                ->assertSee('These credentials do not match our records.')
                ->driver->manage()->deleteAllCookies();
        });
    }
}
