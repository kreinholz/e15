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

    /**
     * A Dusk test example.
     *
     * @return void
     */
    public function testExample()
    {
        $this->browse(function (Browser $browser) {
            $browser->visit('/')
                    ->assertSeeLink('login');
        });
    }
}
