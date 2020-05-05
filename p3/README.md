# Project 3
+ By: Kevin Reinholz
+ Production URL: <https://e15p3.kreinholz.me>

## Feature summary
+ State Oversight Agency Reviewers (Users) can register/log in
+ Users can view prior completed Rail Transit Agency Safety Plan reviews/inspections
+ Users can create a new review/inspection, and fill out an interactive checklist to review an inspected Rail Transit Agency's Safety Plan
+ The User who created a review/inspection can edit or delete his/her own inspections
+ The Safety Oversight Manager (seeded user Jill Harvard for demo purposes) can edit or delete any inspection
+ The Safety Oversight Manager can view and create checklists, and add/remove checklist_items to/from a checklist
+ The Safety Oversight Manager can create new checklist_items for addition to checklists
+ /checklists routes are protected and only the Safety Oversight Manager can access them
+ /inspections routes and protected and only authenticated users (seeded users Jamal Harvard and Jill Harvard for demo purposes) can access them. Guests are invited to register for accounts, which will grant them access to the /inspections routes
+ Features (at least 2) making this application unique from the course demo "Bookmark" application: (1) an additional layer of protected routes within the auth protected routes limiting access to `/checklists` routes to users with the job title "Safety Oversight Manager." (2) Conditional display of information within Blade templates based on a user's job title. (3) Conditional routing within `/inspections` based on whether an inspector has marked the boolean value "completed" as true or left it at its default of false. (True causes the `/inspections/{id}` link to route the user to the show view, false causes routing to the edit view). (4) "Cloning" of rows found in the `checklists`, `checklist_items`, and pivot table between the 2 to `inspection_cls`, `inspection_items`, and pivot table between the 2 when a new inspection is started, in order to preserve "historical" versions of checklists and checklist items in the event they are later modified, and to protect the integrity of past inspection data.
  
## Database summary
+ My application has 8 tables in total (`users`, `inspections`, `checklists`, `checklist_items`, a join table for `checklists` and `checklist_items`, and "snapshot" tables `inspection_cls`, `inspection_items`, and a join table for `inspection_cls` and `inspection_items` that clone their checklist-related counterparts and store them separately so subsequent changes to the checklists/checklist_items won't affect already completed inspections)
+ There's a one-to-one (foreign key) relationship between `inspections` and `users`
+ There's a many-to-many relationship between `checklists` and `checklist_items`
+ There's a many-to-many relationship between `inspection_cls` and `inspection_items`
+ There's a one-to-one (foreign key) relationship between `inspections` and `inspection_cls`

## Outside resources
+ <https://wisconsindot.gov/Documents/doing-bus/local-gov/astnce-pgms/transit/compliance/sso-append.pdf> (checklist begins on page 113)
+ <https://laravel.com/docs/4.2/schema>
+ <https://laracasts.com/discuss/channels/laravel/saving-multiple-records-to-database-with-many-to-many-relation?page=1>
+ <https://laravel.com/docs/5.2/collections#method-diff>
+ <https://laracasts.com/discuss/channels/laravel/saving-multiple-records-to-database-with-many-to-many-relation?page=1>
+ <https://php.net/manual/en/function.array-merge.php>
+ <https://dev.mysql.com/doc/refman/8.0/en/integer-types.html>
+ <https://laravel.com/docs/7.x/validation>
+ <https://stackoverflow.com/a/141114>
+ <https://laravel.com/docs/7.x/middleware#global-middleware>
+ <https://laravel.com/docs/7.x/eloquent-relationships#many-to-many>
+ <https://laravel.com/docs/5.6/eloquent#eloquent-model-conventions>
+ <https://github.com/susanBuck/e15-spring20/issues/38>
+ <https://laravel.com/docs/5.8/queries#retrieving-results>
+ <https://wisconsindot.gov/_catalogs/masterpage/AgencyTemplate1/css/styles.css>
+ <https://stackoverflow.com/a/39524462>
+ <https://hesweb.dev/e15/notes/laravel/auth-setup>
+ <https://stackoverflow.com/a/30414884>
+ <https://medium.com/justlaravel/how-to-use-middleware-for-content-restriction-based-on-user-role-in-laravel-2d0d8f8e94c6>
+ <https://www.php.net/manual/en/function.in-array.php>
+ <https://laravel.com/docs/7.x/dusk#interacting-with-elements>
+ <https://laravel.com/docs/7.x/dusk#authentication>
+ <https://laravel.com/docs/7.x/dusk#available-assertions>
+ <https://www.5balloons.info/migrating-and-seeding-database-in-laravel-dusk/>
+ <https://github.com/spatie/laravel-activitylog/issues/486>
+ <https://stackoverflow.com/a/49827194>

## Notes for instructor
+ This is a prototype/proof-of-concept web app for a friend who works in the Rail Transit Safety field (state government). The idea was to take what is currently a pen-and-paper safety plan inspection checklist from which written inspection reports are based, and turn it into a fillable inspection form accessible from the web from which historical reports can be viewed from the web interface and stored in an easily maintainable database
+ While abbreviating a table name is undesirable, I ran into a MySQL limitation when naming what is now `inspection_cls` the more logical `inspection_checklists`. While this name was accepted for the table, the join table between it and `inspection_items` failed due to an SQL length limitation error. As a result, I was forced to abbreviate/shorten the table name in order to make the Many-to-Many relationship work
+ I did not expand beyond the default authentication routes--therefore, email verification and password reset have *not* been enabled
+ My focus was very much on the database and on the relationships between database tables. The goal of this project was to provide an easy-to-use web interface for interacting with the database, and to allow customization of the checklist itself, as well as electronic storage of inspection reports. As such, a minimum of effort went into aesthetics
+ If I were to write this app "for the real world," I would utilize Vue.js or another JavaScript framework and AJAX calls to allow "snappier" loading and updating of `inspection_items` rather than requiring submittal of a form containing data on *all* items associated with an inspection every time the user wants to make an update. However, focusing on the server side, I did want users to be able to update multiple items with a single form submission, rather than requiring each item to be updated separately (which I could foresee getting pretty tedious)
+ Another "real world" difference is I would never allow the user to select his/her job title during registration the way I currently have the database and route permissions set up. Instead, I would either manually have an administrator go in and set the job title to "Safety Oversight Manager" or add a "verified" boolean field to the users table so only those who truly need elevated access privileges had them