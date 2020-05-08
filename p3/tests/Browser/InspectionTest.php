<?php

namespace Tests\Browser;

use Illuminate\Foundation\Testing\DatabaseMigrations;
use Laravel\Dusk\Browser;
use Tests\DuskTestCase;

class InspectionTest extends DuskTestCase
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
     * A Dusk test to visit the /inspections route.
     *
     * @return void
     */
    public function testVisitInspections()
    {
        $this->browse(function (Browser $browser) {
            $browser->visit('/login')
                ->type('email', 'jamal@harvard.edu')
                ->type('password', 'helloworld')
                ->press('Login')
                ->visit('/inspections')
                ->assertSeeLink('Agency Safety Plan Review of Atlantic Railway Authority on Apr 15, 2020 (Completed)');
        });
    }
    /**
     * A Dusk test to visit the /inspections/create route.
     *
     * @return void
     */
    public function testVisitInspectionCreate()
    {
        $this->browse(function (Browser $browser) {
            $browser->visit('/inspections/create')
                ->assertSee('This form will allow you to start a new Agency Safety Plan Review.');
        });
    }
    
    /**
     * A Dusk test of unsuccessful inspection creation (invalid date--only possible on older browsers).
     *
     * @return void
     */
    public function testInspectionCreateInvalidDate()
    {
        $this->browse(function (Browser $browser) {
            $browser->visit('/inspections/create')
                ->type('rail_transit_agency', 'Dusk Transit Agency')
                ->type('inspection_date', '13/32/10000')
                ->select('checklist', '2')
                ->press('Create Inspection')
                ->assertVisible('.alert')
                ->assertSee('The inspection date does not match the format Y-m-d.')
                ->assertInputValue('rail_transit_agency', 'Dusk Transit Agency');
        });
    }

    /**
     * A Dusk test of successful inspection creation.
     *
     * @return void
     */
    public function testInspectionCreateSuccessfully()
    {
        $this->browse(function (Browser $browser) {
            $browser->visit('/inspections/create')
            ->type('rail_transit_agency', 'Dusk Transit Agency')
            ->type('inspection_date', '12/31/2020')
            ->select('checklist', '2')
            ->press('Create Inspection')
            ->assertVisible('.flash-alert')
            ->assertSee('Your inspection of Dusk Transit Agency with an inspection date of 2020-12-31 was created.')
            ->visit('/inspections')
            ->assertSeeLink('Agency Safety Plan Review of Dusk Transit Agency on Dec 31, 2020 (In-Progress)')
            ->clickLink('Agency Safety Plan Review of Dusk Transit Agency on Dec 31, 2020 (In-Progress)')
            ->assertPathIs('/inspections/4/edit')
            ->assertSee('Continue or Edit an Agency Safety Plan Review');
        });
    }
}
