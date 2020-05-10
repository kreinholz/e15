<?php

namespace Tests\Browser;

use Illuminate\Foundation\Testing\DatabaseMigrations;
use Laravel\Dusk\Browser;
use Tests\DuskTestCase;

class ChecklistTest extends DuskTestCase
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
     * A Dusk test to visit the /checklists route.
     *
     * @return void
     */
    public function testVisitChecklists()
    {
        $this->browse(function (Browser $browser) {
            $browser->visit('/login')
            ->type('email', 'jill@harvard.edu')
            ->type('password', 'helloworld')
            ->press('Login')
            ->visit('/checklists')
            ->assertSeeLink('2020-04-22 Full Checklist');
        });
    }
    /**
     * A Dusk test to visit the /checklists/create route.
     *
     * @return void
     */
    public function testVisitChecklistsCreate()
    {
        $this->browse(function (Browser $browser) {
            $browser->visit('/checklists/create')
            ->assertSee('This form will allow you to create a new checklist');
        });
    }

    /* The below test involves checking a checkbox where the name is an array--ref: https://github.com/laravel/dusk/issues/83 */

    /**
     * A Dusk test of unsuccessful checklist creation (missing title).
     *
     * @return void
     */
    public function testChecklistCreateMissingField()
    {
        $this->browse(function (Browser $browser) {
            $browser->visit('/checklists/create')
            ->check('checklist_items[]', '1')
            ->press('Create Checklist')
            ->assertVisible('.alert')
            ->assertSee('The title field is required.')
            ->assertChecked('checklist_items[]', '1');
        });
    }

    /**
     * A Dusk test of successful checklist creation.
     *
     * @return void
     */
    public function testChecklistCreateSuccessfully()
    {
        $this->browse(function (Browser $browser) {
            $browser->visit('/checklists/create')
            ->check('checklist_items[]', '1')
            ->type('title', 'Dusk Test Checklist')
            ->press('Create Checklist')
            ->assertVisible('.flash-alert')
            ->assertSee('Your checklist Dusk Test Checklist was added.')
            ->visit('/checklists')
            ->assertSeeLink('Dusk Test Checklist')
            ->clickLink('Dusk Test Checklist')
            ->assertPathIs('/checklists/3')
            ->assertSee('A policy statement is developed for the System Safety Program Plan (SSPP).');
        });
    }

    /**
     * A Dusk test of unsuccessful checklist editing due to validation error.
     *
     * @return void
     */
    public function testChecklistMissingField()
    {
        $this->browse(function (Browser $browser) {
            $browser->visit('/checklists/1/edit')
                ->type('title', '')
                ->press('Update Checklist')
                ->assertVisible('.alert')
                ->assertSee('The title field is required.')
                ->assertInputValue('title', '');
        });
    }

    /**
     * A Dusk test of successful checklist editing.
     *
     * @return void
     */
    public function testChecklistEditing()
    {
        $this->browse(function (Browser $browser) {
            $browser->visit('/checklists/1/edit')
            ->assertInputValue('title', '2020-04-22 Full Checklist')
            ->uncheck('existing_items[]', '11')
            ->press('Update Checklist')
            ->assertVisible('.flash-alert')
            ->assertSee('Your changes were saved.');
        });
    }

    /**
     * A Dusk test of checklist deletion.
     *
     * @return void
     */
    public function testChecklistDeletion()
    {
        $this->browse(function (Browser $browser) {
            $browser->visit('/checklists/1/delete')
            ->assertSee('Confirm deletion')
            ->press('Yes, I want to delete it')
            ->assertVisible('.flash-alert')
            ->assertSee('The “2020-04-22 Full Checklist” checklist was removed.')
            ->assertPathIs('/checklists');
        });
    }

    /**
     * A Dusk test of attempting to navigate to a non-existent checklist.
     *
     * @return void
     */
    public function testChecklistNotFound()
    {
        $this->browse(function (Browser $browser) {
            $browser->visit('/checklists/4')
            ->assertSee('Checklist not found')
            ->driver->manage()->deleteAllCookies();
        });
    }
}
