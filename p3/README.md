*Any instructions/notes in italics should be removed from the template before submitting*

# Project 3
+ By: Kevin Reinholz
+ Production URL: <http://e15p3.kreinholz.me>

## Feature summary
*Outline a summary of features that your application has. The following details are from a hypothetical project called "Movie Tracker". Note that it is similar to Bookmark, yet it has its own unique features. Delete this example and replace with your own feature summary*

+ State Oversight Agency Reviewers (Users) can register/log in
+ Users can view prior completed Rail Transit Agency Safety Plan reviews/inspections
+ Users can create a new review/inspection, and fill out an interactive checklist to review an inspected Rail Transit Agency's Safety Plan
+ The User who created a review/inspection can edit his/her inspections
+ The Safety Oversight Manager (seeded user Jill Harvard for demo purposes) can edit or delete a review/inspection
+ The Safety Oversight Manager can view and create checklists, and add/remove checklist_items from a checklist
+ The Safety Oversight Manager can create new checklist_items and add them to a checklist
+ checklist related routes are protected and only the Safety Oversight Manager can access them
+ inspection related routes and protected and only authenticated users (seeded users Jamal Harvard and Jill Harvard for demo purposes) can access them. Guests are invited to register for accounts
+ Features (at least 2) making this application unique from the course demo "Bookmark" application: (1) an additional layer of protected routes within the auth protected routes limiting access to `/checklists` routes to users with the job title "Safety Oversight Manager." (2) Conditional display of information without Blade templates based on a user's job title. (3) Conditional routing within `/inspections` based on whether an inspector has marked the boolean value "completed" as true or left it at its default of false. (True causes the `/inspections/{id}` link to route the user to the show view, false causes routing to the edit view). (4) "Cloning" of rows found in the `checklists`, `checklist_items`, and pivot table between the 2 to `inspection_cls`, `inspection_items`, and pivot table between the 2 when a new inspection is started, in order to preserve "historical" versions of checklists and checklist items in the event they are later modified, and to protect the integrity of past inspection data.
  
## Database summary
*Describe the tables and relationships used in your database. Delete the examples below and replace with your own info.*

+ My application has 8 tables in total (`users`, `inspections`, `checklists`, `checklist_items`, a join table for `checklists` and `checklist_items`, and "snapshot" tables `inspection_cls`, `inspection_items`, and a join table for `inspection_cls` and `inspection_items` that clone their checklist-related counterparts and freeze them in time so subsequent changes to the checklists/checklist_items won't affect already completed inspections)
+ There's a one-to-one (foreign key) relationship between `inspections` and `users`
+ There's a many-to-many relationship between `checklists` and `checklist_items`
+ There's a many-to-many relationship between `inspection_cls` and `inspection_items`
+ There's a one-to-one (foreign key) relationship between `inspections` and `inspection_cls`

## Outside resources
+ <https://wisconsindot.gov/Documents/doing-bus/local-gov/astnce-pgms/transit/compliance/sso-append.pdf> (checklist begins on page 113)
+ <https://laravel.com/docs/4.2/schema>
+ Various resources commented contectually within various project files--to be listed here prior to project3 submission

## Notes for instructor
+ This is a prototype/proof-of-concept web app for a friend who works in the Rail Transit Safety field (state government). The idea was to take what is currently a pen-and-paper safety plan inspection checklist from which written inspection reports are based, and turn it into a fillable inspection form accessible from the web from which historical reports can be viewed from the web interface and stored in an easily maintainable database.
+ While abbreviating a table name is undesirable, I ran into a MySQL limitation when naming what is now `inspection_cls` the more logical `inspection_checklists`. While this name was accepted for the table, the join table between it and `inspection_items` failed due to an SQL length limitation error. As a result, I was forced to abbreviate/shorten the table name in order to make the Many-to-Many relationship work.