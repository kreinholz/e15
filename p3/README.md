*Any instructions/notes in italics should be removed from the template before submitting*

# Project 3
+ By: Kevin Reinholz
+ Production URL: <http://e15p3.kreinholz.me>

## Feature summary
*Outline a summary of features that your application has. The following details are from a hypothetical project called "Movie Tracker". Note that it is similar to Bookmark, yet it has its own unique features. Delete this example and replace with your own feature summary*

+ State Oversight Agency Reviewers (Users) can register/log in
+ Users can view prior completed Rail Transit Agency Safety Plan reviews/inspections
+ Users can create a new review/inspection, and fill out an interactive checklist to review an inspected Rail Transit Agency's Safety Plan
+ The User who created a review/inspection can edit his/her checklist
+ The Safety Oversight Manager (seeded user Jill Harvard for demo purposes) can delete a review/inspection
+ The Safety Oversight Manager can view and create checklists, and add/remove checklist_items from a checklist
+ The Safety Oversight Manager can create new checklist_items and add them to a checklist
+ checklist related routes are protected and only the Safety Oversight Manager can access them
+ inspection related routes and protected and only authenticated users (seeded users Jamal Harvard and Jill Harvard for demo purposes) can access them. Guests are invited to register for accounts
  
## Database summary
*Describe the tables and relationships used in your database. Delete the examples below and replace with your own info.*

+ My application has 8 tables in total (`users`, `inspections`, `checklists`, `checklist_items`, a join table for `checklists` and `checklist_items`, and "snapshot" tables `inspection_checklists`, `inspection_items`, and a join table for `inspection_checklists` and `inspection_items` that clone their checklist-related counterparts and freeze them in time so subsequent changes to the checklists/checklist_items won't affect already completed inspections)
+ There's a one-to-one (foreign key) relationship between `inspections` and `users`
+ There's a many-to-many relationship between `checklists` and `checklist_items`
+ There's a many-to-many relationship between `inspection_checklists` and `inspection_items`
+ There's a one-to-one (foreign key) relationship between `inspections` and `inspection_checklists`
+ There's a replicate()-based "relationship" between `checklists` and `inspection_checklists`, and between `checklist_items` and `inspection_items`, to preserve integrity of inspection data while allowing updates to checklists and checklist_items for use in current inspections

## Outside resources
+ <https://wisconsindot.gov/Documents/doing-bus/local-gov/astnce-pgms/transit/compliance/sso-append.pdf> (checklist begins on page 113)
+ <https://laravel.com/docs/4.2/schema>

## Notes for instructor
+ This is a prototype/proof-of-concept web app for a friend who works in the Rail Transit Safety field (state government). The idea was to take what is currently a pen-and-paper safety plan inspection checklist from which written inspection reports are based, and turn it into a fillable inspection form accessible from the web from which historical reports can be viewed from the web interface and stored in an easily maintainable database.

