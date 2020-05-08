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

    /**
     * A Dusk test to visit the /inspections/2 show route.
     *
     * @return void
     */
    public function testVisitInspectionShow()
    {
        $this->browse(function (Browser $browser) {
            $browser->visit('/inspections/2')
                ->assertSee('Rail Transit Agency (RTA): Atlantic Railway Authority');
        });
    }

    /**
     * A Dusk test of unsuccessful inspection updating due to validation error.
     *
     * @return void
     */
    public function testInspectionInvalidField()
    {
        $this->browse(function (Browser $browser) {
            $browser->visit('/inspections/3/edit')
                ->assertInputValue('rail_transit_agency', 'Zebra Railways')
                ->type('page_references[15]', 'six')
                ->press('Save Changes')
                ->assertVisible('.alert')
                ->assertSee('The page reference must be an integer.')
                ->assertInputValueIsNot('page_references[15]', 'six');
        });
    }

    /**
     * A Dusk test of successful inspection updating after unchecking a checkbox.
     *
     * @return void
     */
    public function testInspectionUncheckBox()
    {
        $this->browse(function (Browser $browser) {
            $browser->visit('/inspections/3/edit')
                ->uncheck('includeds[15]')
                ->press('Save Changes')
                ->assertVisible('.flash-alert')
                ->assertSee('Your changes were saved.')
                ->assertNotChecked('includeds[15]');
        });
    }

    /**
     * A Dusk test of successfully marking an inspection as completed.
     *
     * @return void
     */
    public function testInspectionCompletion()
    {
        $this->browse(function (Browser $browser) {
            $browser->visit('/inspections/3/edit')
                ->check('completed')
                ->press('Save Changes')
                ->assertVisible('.flash-alert')
                ->assertSee('Your changes were saved and the inspection marked complete.')
                ->assertPathIs('/inspections/3');
        });
    }

    /**
     * A Dusk test of inspection deletion.
     *
     * @return void
     */
    public function testInspectionDeletion()
    {
        $this->browse(function (Browser $browser) {
            $browser->visit('/inspections/3/delete')
            ->assertSee('Confirm deletion')
            ->press('Yes, I want to delete it')
            ->assertVisible('.flash-alert')
            ->assertSee('The Inspection of Zebra Railways was removed.')
            ->assertPathIs('/inspections');
        });
    }

    /**
     * A Dusk test of attempting to navigate to a non-existent inspection.
     *
     * @return void
     */
    public function testInspectionNotFound()
    {
        $this->browse(function (Browser $browser) {
            $browser->visit('/inspections/5')
            ->assertSee('Agency Safety Plan Review not found.');
        });
    }

    /**
     * A Dusk test of attempting to exceed this user's access privileges.
     *
     * @return void
     */
    public function testRouteSecurity()
    {
        $this->browse(function (Browser $browser) {
            $browser->visit('/inspections/1/edit')
            ->assertSee("Sorry, you don't have permission to edit this inspection.")
            ->visit('/checklists/1')
            ->assertPathIs('/')
            ->visit('/checklist-items/1')
            ->assertPathIs('/')
            ->visit('/omega')
            ->assertSee('404')
            ->driver->manage()->deleteAllCookies();
        });
    }
}
