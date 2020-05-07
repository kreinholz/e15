<?php

namespace Tests\Browser;

use Illuminate\Foundation\Testing\DatabaseMigrations;
use Laravel\Dusk\Browser;
use Tests\DuskTestCase;

class ChecklistItemTest extends DuskTestCase
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
     * A Dusk test to visit the /checklist-items route.
     *
     * @return void
     */
    public function testVisitChecklistItems()
    {
        $this->browse(function (Browser $browser) {
            $browser->visit('/login')
            ->type('email', 'jill@harvard.edu')
            ->type('password', 'helloworld')
            ->press('Login')
            ->visit('/checklist-items')
            ->assertSeeLink('Add a New Checklist Item');
        });
    }

    /**
     * A Dusk test to visit the /checklist-items/create route.
     *
     * @return void
     */
    public function testVisitChecklistItemCreate()
    {
        $this->browse(function (Browser $browser) {
            $browser->visit('/checklist-items/create')
            ->assertSee('This form will allow you to create a new checklist item');
        });
    }

    /**
     * A Dusk test of unsuccessful checklist item creation (invalid field).
     *
     * @return void
     */
    public function testChecklistItemCreateInvalidField()
    {
        $this->browse(function (Browser $browser) {
            $browser->visit('/checklist-items/create')
            ->type('item_number', 'One')
            ->type('item_name', 'Test Item')
            ->type('plan_requirement', 'This item is actually a test, and fulfills no requirement of any plan')
            ->press('Add New Item')
            ->assertVisible('.alert')
            ->assertSee('The item number must be between 1 and 3 digits.')
            ->assertInputValue('item_number', 'One');
        });
    }

    /**
     * A Dusk test of successful checklist item creation.
     *
     * @return void
     */
    public function testChecklistItemCreateSuccessfully()
    {
        $this->browse(function (Browser $browser) {
            $browser->visit('/checklist-items/create')
            ->type('item_number', '10')
            ->type('item_name', 'Test Item')
            ->type('plan_requirement', 'This item is actually a test, and fulfills no requirement of any plan')
            ->press('Add New Item')
            ->assertVisible('.flash-alert')
            ->assertSee('Your checklist item “This item is actually a test, and fulfills no requirement of any plan” was added.')
            ->assertPathIs('/checklist-items');
        });
    }

    /**
     * A Dusk test of successful checklist item redirect from non-existent show route to edit route.
     *
     * @return void
     */
    public function testChecklistItemRedirect()
    {
        $this->browse(function (Browser $browser) {
            $browser->visit('/checklist-items/4')
            ->assertPathIs('/checklist-items/4/edit');
        });
    }

    /**
     * A Dusk test of unsuccessful checklist item editing.
     *
     * @return void
     */
    public function testChecklistItemEditingMissingField()
    {
        $this->browse(function (Browser $browser) {
            $browser->visit('/checklist-items/1/edit')
            ->assertInputValue('plan_requirement', 'A policy statement is developed for the System Safety Program Plan (SSPP).')
            ->type('plan_requirement', '')
            ->press('Update Checklist Item')
            ->assertVisible('.alert')
            ->assertSee('The plan requirement field is required.');
        });
    }

    /**
     * A Dusk test of successful checklist item editing.
     *
     * @return void
     */
    public function testChecklistItemEditing()
    {
        $this->browse(function (Browser $browser) {
            $browser->visit('/checklist-items/1/edit')
            ->assertInputValue('plan_requirement', 'A policy statement is developed for the System Safety Program Plan (SSPP).')
            ->type('plan_requirement', 'This is a Dusk Test update and not a real plan requirement')
            ->press('Update Checklist Item')
            ->assertVisible('.flash-alert')
            ->assertSee('Your changes to “This is a Dusk Test update and not a real plan requirement” were saved.')
            ->assertPathIs('/checklist-items')
            ->driver->manage()->deleteAllCookies();
        });
    }
}
