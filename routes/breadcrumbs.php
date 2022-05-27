<?php
// Note: Laravel will automatically resolve `Breadcrumbs::` without
// this import. This is nice for IDE syntax and refactoring.
use Diglactic\Breadcrumbs\Breadcrumbs;
use Diglactic\Breadcrumbs\Generator as BreadcrumbTrail;

// This import is also not required, and you could replace `BreadcrumbTrail $trail`
//  with `$trail`. This is nice for IDE type checking and completion.


Breadcrumbs::for('home', function (BreadcrumbTrail $breadcrumbs) {
    $breadcrumbs->push('Home', route('home'));
});


// Admin Home
Breadcrumbs::for('dashboard', function (BreadcrumbTrail $breadcrumbs) {
    $breadcrumbs->parent('home');
    $breadcrumbs->push('Admin', route('dashboard'));
});

//Users
Breadcrumbs::for('users.index', function (BreadcrumbTrail $breadcrumbs) {
    $breadcrumbs->parent('dashboard');
    $breadcrumbs->push('Users', route('users.index'));
});

Breadcrumbs::for('users.create', function ($breadcrumbs) {
    $breadcrumbs->parent('users.index');
    $breadcrumbs->push('Create', route('users.create'));
});

Breadcrumbs::for('users.edit', function (BreadcrumbTrail $breadcrumbs) {
    $breadcrumbs->parent('users.index');
    $breadcrumbs->push('Edit', route('users.edit', 0));
});

Breadcrumbs::for('users.show', function (BreadcrumbTrail $breadcrumbs) {
    $breadcrumbs->parent('users.index');
    $breadcrumbs->push('Details', route('users.show', 0));
});

Breadcrumbs::for('users.destroy', function (BreadcrumbTrail $breadcrumbs) {
    $breadcrumbs->push('Delete Users', route('users.create'));
});

//Roles
Breadcrumbs::for('roles.index', function (BreadcrumbTrail $breadcrumbs) {
    $breadcrumbs->parent('dashboard');
    $breadcrumbs->push('Roles', route('roles.index'));
});

Breadcrumbs::for('roles.create', function (BreadcrumbTrail $breadcrumbs) {
    $breadcrumbs->parent('roles.index');
    $breadcrumbs->push('Create', route('roles.create'));
});

Breadcrumbs::for('roles.edit', function (BreadcrumbTrail $breadcrumbs) {
    $breadcrumbs->parent('roles.index');
    $breadcrumbs->push('Edit', route('roles.edit', 0));
});

Breadcrumbs::for('roles.show', function (BreadcrumbTrail $breadcrumbs) {
    $breadcrumbs->parent('roles.index');
    $breadcrumbs->push('Details', route('roles.show', 0));
});

Breadcrumbs::for('roles.destroy', function (BreadcrumbTrail $breadcrumbs) {
    $breadcrumbs->push('Delete Roles', route('roles.create'));
});

//Permissions
Breadcrumbs::for('permissions.index', function (BreadcrumbTrail $breadcrumbs) {
    $breadcrumbs->parent('dashboard');
    $breadcrumbs->push('Permissions', route('permissions.index'));
});

Breadcrumbs::for('permissions.create', function (BreadcrumbTrail $breadcrumbs) {
    $breadcrumbs->parent('permissions.index');
    $breadcrumbs->push('Create', route('roles.create'));
});

Breadcrumbs::for('permissions.edit', function (BreadcrumbTrail $breadcrumbs) {
    $breadcrumbs->parent('permissions.index');
    $breadcrumbs->push('Edit', route('permissions.edit', 0));
});

Breadcrumbs::for('permissions.show', function (BreadcrumbTrail $breadcrumbs) {
    $breadcrumbs->parent('permissions.index');
    $breadcrumbs->push('Details', route('permissions.show', 0));
});

Breadcrumbs::for('permissions.destroy', function (BreadcrumbTrail $breadcrumbs) {
    $breadcrumbs->push('Delete Permissions', route('permissions.create'));
});

//User Details
Breadcrumbs::for('user-details.index', function (BreadcrumbTrail $breadcrumbs) {
    $breadcrumbs->parent('dashboard');
    $breadcrumbs->push('User Details', route('user-details.index'));
});

Breadcrumbs::for('user-details.create', function (BreadcrumbTrail $breadcrumbs) {
    $breadcrumbs->parent('user-details.index');
    $breadcrumbs->push('Create', route('user-details.create'));
});

Breadcrumbs::for('user-details.edit', function (BreadcrumbTrail $breadcrumbs) {
    $breadcrumbs->parent('user-details.index');
    $breadcrumbs->push('Edit', route('user-details.edit', 0));
});

Breadcrumbs::for('user-details.show', function (BreadcrumbTrail $breadcrumbs) {
    $breadcrumbs->parent('user-details.index');
    $breadcrumbs->push('Details', route('user-details.show', 0));
});

Breadcrumbs::for('user-details.destroy', function (BreadcrumbTrail $breadcrumbs) {
    $breadcrumbs->push('Delete User Details', route('user-details.create'));
});

//Teachers
Breadcrumbs::for('teachers.index', function (BreadcrumbTrail $breadcrumbs) {
    $breadcrumbs->parent('dashboard');
    $breadcrumbs->push('Teacher', route('teachers.index'));
});

Breadcrumbs::for('teachers.create', function (BreadcrumbTrail $breadcrumbs) {
    $breadcrumbs->parent('teachers.index');
    $breadcrumbs->push('Create', route('teachers.create'));
});

Breadcrumbs::for('teachers.edit', function (BreadcrumbTrail $breadcrumbs) {
    $breadcrumbs->parent('teachers.index');
    $breadcrumbs->push('Edit', route('teachers.edit', 0));
});

Breadcrumbs::for('teachers.show', function (BreadcrumbTrail $breadcrumbs) {
    $breadcrumbs->parent('teachers.index');
    $breadcrumbs->push('Details', route('teachers.show', 0));
});

Breadcrumbs::for('teachers.destroy', function (BreadcrumbTrail $breadcrumbs) {
    $breadcrumbs->push('Delete Teachers', route('teachers.create'));
});

//Students
Breadcrumbs::for('students.index', function (BreadcrumbTrail $breadcrumbs) {
    $breadcrumbs->parent('dashboard');
    $breadcrumbs->push('Student', route('students.index'));
});

Breadcrumbs::for('students.create', function (BreadcrumbTrail $breadcrumbs) {
    $breadcrumbs->parent('students.index');
    $breadcrumbs->push('Create', route('students.create'));
});

Breadcrumbs::for('students.edit', function (BreadcrumbTrail $breadcrumbs) {
    $breadcrumbs->parent('students.index');
    $breadcrumbs->push('Edit', route('students.edit', 0));
});

Breadcrumbs::for('students.show', function (BreadcrumbTrail $breadcrumbs) {
    $breadcrumbs->parent('students.index');
    $breadcrumbs->push('Details', route('students.show', 0));
});

Breadcrumbs::for('students.destroy', function (BreadcrumbTrail $breadcrumbs) {
    $breadcrumbs->push('Delete Student', route('students.create'));
});

//Book
Breadcrumbs::for('books.index', function (BreadcrumbTrail $breadcrumbs) {
    $breadcrumbs->parent('dashboard');
    $breadcrumbs->push('Books', route('books.index'));
});

Breadcrumbs::for('books.stockhistory', function (BreadcrumbTrail $breadcrumbs) {
    $breadcrumbs->parent('dashboard');
    $breadcrumbs->push('Books Inventory', route('books.stockhistory'));
});

Breadcrumbs::for('books.create', function (BreadcrumbTrail $breadcrumbs) {
    $breadcrumbs->parent('books.index');
    $breadcrumbs->push('Create', route('books.create'));
});

Breadcrumbs::for('books.edit', function (BreadcrumbTrail $breadcrumbs) {
    $breadcrumbs->parent('books.index');
    $breadcrumbs->push('Edit', route('books.edit', 0));
});

Breadcrumbs::for('books.show', function (BreadcrumbTrail $breadcrumbs) {
    $breadcrumbs->parent('books.index');
    $breadcrumbs->push('Details', route('books.show', 0));
});

Breadcrumbs::for('books.destroy', function (BreadcrumbTrail $breadcrumbs) {
    $breadcrumbs->push('Delete Books', route('books.create'));
});

// Book Categories
Breadcrumbs::for('categories.index', function (BreadcrumbTrail $breadcrumbs) {
    $breadcrumbs->parent('books.index');
    $breadcrumbs->push('Categories', route('categories.index'));
});

Breadcrumbs::for('categories.create', function (BreadcrumbTrail $breadcrumbs) {
    $breadcrumbs->parent('categories.index');
    $breadcrumbs->push('Create', route('categories.create'));
});

Breadcrumbs::for('categories.edit', function (BreadcrumbTrail $breadcrumbs) {
    $breadcrumbs->parent('categories.index');
    $breadcrumbs->push('Edit', route('categories.edit', 0));
});

Breadcrumbs::for('categories.show', function (BreadcrumbTrail $breadcrumbs) {
    $breadcrumbs->parent('categories.index');
    $breadcrumbs->push('Details', route('categories.show', 0));
});

Breadcrumbs::for('categories.destroy', function (BreadcrumbTrail $breadcrumbs) {
    $breadcrumbs->push('Delete Categories', route('categories.create'));
});

//EBooks
Breadcrumbs::for('ebooks.index', function (BreadcrumbTrail $breadcrumbs) {
    $breadcrumbs->parent('dashboard');
    $breadcrumbs->push('Book', route('ebooks.index'));
});

Breadcrumbs::for('ebooks.create', function (BreadcrumbTrail $breadcrumbs) {
    $breadcrumbs->parent('ebooks.index');
    $breadcrumbs->push('Create', route('ebooks.create'));
});

Breadcrumbs::for('ebooks.edit', function (BreadcrumbTrail $breadcrumbs) {
    $breadcrumbs->parent('ebooks.index');
    $breadcrumbs->push('Edit', route('ebooks.edit', 0));
});

Breadcrumbs::for('ebooks.show', function (BreadcrumbTrail $breadcrumbs) {
    $breadcrumbs->parent('ebooks.index');
    $breadcrumbs->push('Details', route('ebooks.show', 0));
});

Breadcrumbs::for('ebooks.destroy', function (BreadcrumbTrail $breadcrumbs) {
    $breadcrumbs->push('Delete EBooks', route('ebooks.create'));
});

//Sales
Breadcrumbs::for('sales.index', function (BreadcrumbTrail $breadcrumbs) {
    $breadcrumbs->parent('dashboard');
    $breadcrumbs->push('Sales', route('sales.index'));
});

Breadcrumbs::for('sales.create', function (BreadcrumbTrail $breadcrumbs) {
    $breadcrumbs->parent('sales.index');
    $breadcrumbs->push('Create', route('sales.create'));
});

Breadcrumbs::for('sales.edit', function (BreadcrumbTrail $breadcrumbs) {
    $breadcrumbs->parent('sales.index');
    $breadcrumbs->push('Edit', route('sales.edit', 0));
});

Breadcrumbs::for('sales.show', function (BreadcrumbTrail $breadcrumbs) {
    $breadcrumbs->parent('sales.index');
    $breadcrumbs->push('Details', route('sales.show', 0));
});

Breadcrumbs::for('sales.invoice', function (BreadcrumbTrail $breadcrumbs) {
    $breadcrumbs->parent('sales.index');
    $breadcrumbs->push('Invoice', route('sales.invoice', 0));
});

Breadcrumbs::for('sales.destroy', function (BreadcrumbTrail $breadcrumbs) {
    $breadcrumbs->push('Delete Sales', route('sales.create'));
});
//Sales Payment
Breadcrumbs::for('sale-payments.index', function (BreadcrumbTrail $breadcrumbs) {
    $breadcrumbs->parent('sales.index');
    $breadcrumbs->push('Payments', route('sale-payments.index'));
});

Breadcrumbs::for('sale-payments.create', function (BreadcrumbTrail $breadcrumbs) {
    $breadcrumbs->parent('sale-payments.index');
    $breadcrumbs->push('Create', route('sale-payments.create'));
});

Breadcrumbs::for('sale-payments.edit', function (BreadcrumbTrail $breadcrumbs) {
    $breadcrumbs->parent('sale-payments.index');
    $breadcrumbs->push('Edit', route('sale-payments.edit', 0));
});

Breadcrumbs::for('sale-payments.show', function (BreadcrumbTrail $breadcrumbs) {
    $breadcrumbs->parent('sale-payments.index');
    $breadcrumbs->push('Details', route('sale-payments.show', 0));
});

Breadcrumbs::for('sale-payments.invoice', function (BreadcrumbTrail $breadcrumbs) {
    $breadcrumbs->parent('sale-payments.index');
    $breadcrumbs->push('Invoice', route('sale-payments.invoice', 0));
});

Breadcrumbs::for('sale-payments.destroy', function (BreadcrumbTrail $breadcrumbs) {
    $breadcrumbs->push('Delete Sales', route('sale-payments.create'));
});


// Event Management
Breadcrumbs::for('events.index', function ($breadcrumbs) {
    $breadcrumbs->parent('dashboard');
    $breadcrumbs->push('Events', route('events.index'));
});
Breadcrumbs::for('events.archive', function ($breadcrumbs) {
    $breadcrumbs->parent('dashboard');
    $breadcrumbs->push('Events', route('events.archive'));
});

Breadcrumbs::for('events.create', function ($breadcrumbs) {
    $breadcrumbs->parent('events.index');
    $breadcrumbs->push('Create', route('events.create'));
});

Breadcrumbs::for('events.edit', function ($breadcrumbs) {
    $breadcrumbs->parent('events.index');
    $breadcrumbs->push('Edit', route('events.edit', 0));
});

Breadcrumbs::for('events.show', function ($breadcrumbs) {
    $breadcrumbs->parent('events.index');
    $breadcrumbs->push('Details', route('events.show', 0));
});

Breadcrumbs::for('events.destroy', function ($breadcrumbs) {
    $breadcrumbs->push('Delete events', route('events.create'));
});



// Event Management
Breadcrumbs::for('events-registration.index', function ($breadcrumbs) {
    $breadcrumbs->parent('dashboard');
    $breadcrumbs->push('Events Registrations', route('events-registration.index'));
});

Breadcrumbs::for('events-registration.create', function ($breadcrumbs) {
    $breadcrumbs->parent('events-registration.index');
    $breadcrumbs->push('Create', route('events-registration.create'));
});

Breadcrumbs::for('events-registration.edit', function ($breadcrumbs) {
    $breadcrumbs->parent('events-registration.index');
    $breadcrumbs->push('Edit', route('events-registration.edit', 0));
});

Breadcrumbs::for('events-registration.show', function ($breadcrumbs) {
    $breadcrumbs->parent('events-registration.index');
    $breadcrumbs->push('Details', route('events-registration.show', 0));
});

Breadcrumbs::for('events-registration.destroy', function ($breadcrumbs) {
    $breadcrumbs->push('Delete Events Registration', route('events-registration.create'));
});

//Companies
Breadcrumbs::for('companies.index', function (BreadcrumbTrail $breadcrumbs) {
    $breadcrumbs->parent('dashboard');
    $breadcrumbs->push('Companies', route('companies.index'));
});

Breadcrumbs::for('companies.create', function (BreadcrumbTrail $breadcrumbs) {
    $breadcrumbs->parent('companies.index');
    $breadcrumbs->push('Create', route('companies.create'));
});

Breadcrumbs::for('companies.edit', function (BreadcrumbTrail $breadcrumbs) {
    $breadcrumbs->parent('companies.index');
    $breadcrumbs->push('Edit', route('companies.edit', 0));
});

Breadcrumbs::for('companies.show', function (BreadcrumbTrail $breadcrumbs) {
    $breadcrumbs->parent('companies.index');
    $breadcrumbs->push('Details', route('companies.show', 0));
});

Breadcrumbs::for('companies.destroy', function (BreadcrumbTrail $breadcrumbs) {
    $breadcrumbs->push('Delete Companies', route('companies.create'));
});


//Branches
Breadcrumbs::for('branches.index', function ($breadcrumbs) {
    $breadcrumbs->parent('dashboard');
    $breadcrumbs->push('Branches', route('branches.index'));
});

Breadcrumbs::for('branches.create', function ($breadcrumbs) {
    $breadcrumbs->parent('branches.index');
    $breadcrumbs->push('Create', route('branches.create'));
});

Breadcrumbs::for('branches.edit', function ($breadcrumbs) {
    $breadcrumbs->parent('branches.index');
    $breadcrumbs->push('Edit', route('branches.edit', 0));
});

Breadcrumbs::for('branches.show', function ($breadcrumbs) {
    $breadcrumbs->parent('branches.index');
    $breadcrumbs->push('Details', route('branches.show', 0));
});

Breadcrumbs::for('branches.destroy', function ($breadcrumbs) {
    $breadcrumbs->push('Delete Branches', route('branches.create'));
});

//Course Category
Breadcrumbs::for('course-categories.index', function ($breadcrumbs) {
    $breadcrumbs->parent('dashboard');
    $breadcrumbs->push('Course Category', route('course-categories.index'));
});

Breadcrumbs::for('course-categories.create', function ($breadcrumbs) {
    $breadcrumbs->parent('course-categories.index');
    $breadcrumbs->push('Create', route('course-categories.create'));
});

Breadcrumbs::for('course-categories.edit', function ($breadcrumbs) {
    $breadcrumbs->parent('course-categories.index');
    $breadcrumbs->push('Edit', route('course-categories.edit', 0));
});

Breadcrumbs::for('course-categories.show', function ($breadcrumbs) {
    $breadcrumbs->parent('course-categories.index');
    $breadcrumbs->push('Details', route('course-categories.show', 0));
});

Breadcrumbs::for('course-categories.destroy', function ($breadcrumbs) {
    $breadcrumbs->push('Delete Course Category', route('course-categories.create'));
});

//Course Sub Category
Breadcrumbs::for('course-sub-categories.index', function ($breadcrumbs) {
    $breadcrumbs->parent('dashboard');
    $breadcrumbs->push('Course Sub Category', route('course-sub-categories.index'));
});

Breadcrumbs::for('course-sub-categories.create', function ($breadcrumbs) {
    $breadcrumbs->parent('course-sub-categories.index');
    $breadcrumbs->push('Create', route('course-sub-categories.create'));
});

Breadcrumbs::for('course-sub-categories.edit', function ($breadcrumbs) {
    $breadcrumbs->parent('course-sub-categories.index');
    $breadcrumbs->push('Edit', route('course-sub-categories.edit', 0));
});

Breadcrumbs::for('course-sub-categories.show', function ($breadcrumbs) {
    $breadcrumbs->parent('course-sub-categories.index');
    $breadcrumbs->push('Details', route('course-sub-categories.show', 0));
});

Breadcrumbs::for('course-sub-categories.destroy', function ($breadcrumbs) {
    $breadcrumbs->push('Delete Course Sub Category', route('course-sub-categories.create'));
});

//Course Child Category
Breadcrumbs::for('course-child-categories.index', function ($breadcrumbs) {
    $breadcrumbs->parent('dashboard');
    $breadcrumbs->push('Course Child Category', route('course-child-categories.index'));
});

Breadcrumbs::for('course-child-categories.create', function ($breadcrumbs) {
    $breadcrumbs->parent('course-child-categories.index');
    $breadcrumbs->push('Create', route('course-child-categories.create'));
});

Breadcrumbs::for('course-child-categories.edit', function ($breadcrumbs) {
    $breadcrumbs->parent('course-child-categories.index');
    $breadcrumbs->push('Edit', route('course-child-categories.edit', 0));
});

Breadcrumbs::for('course-child-categories.show', function ($breadcrumbs) {
    $breadcrumbs->parent('course-child-categories.index');
    $breadcrumbs->push('Details', route('course-child-categories.show', 0));
});

Breadcrumbs::for('course-child-categories.destroy', function ($breadcrumbs) {
    $breadcrumbs->push('Delete Course Child Category', route('course-child-categories.create'));
});

//Course
Breadcrumbs::for('course.index', function ($breadcrumbs) {
    $breadcrumbs->parent('dashboard');
    $breadcrumbs->push('Course', route('course.index'));
});

Breadcrumbs::for('course.create', function ($breadcrumbs) {
    $breadcrumbs->parent('course.index');
    $breadcrumbs->push('Create', route('course.create'));
});

Breadcrumbs::for('course.edit', function ($breadcrumbs) {
    $breadcrumbs->parent('course.index');
    $breadcrumbs->push('Edit', route('course.edit', 0));
});

Breadcrumbs::for('course.show', function ($breadcrumbs) {
    $breadcrumbs->parent('course.index');
    $breadcrumbs->push('Details', route('course.show', 0));
});

Breadcrumbs::for('course.destroy', function ($breadcrumbs) {
    $breadcrumbs->push('Delete Course', route('course.create'));
});

//Country
Breadcrumbs::for('countries.index', function ($breadcrumbs) {
    $breadcrumbs->parent('dashboard');
    $breadcrumbs->push('Country', route('countries.index'));
});

Breadcrumbs::for('countries.create', function ($breadcrumbs) {
    $breadcrumbs->parent('countries.index');
    $breadcrumbs->push('Create', route('countries.create'));
});

Breadcrumbs::for('countries.edit', function ($breadcrumbs) {
    $breadcrumbs->parent('countries.index');
    $breadcrumbs->push('Edit', route('countries.edit', 0));
});

Breadcrumbs::for('countries.show', function ($breadcrumbs) {
    $breadcrumbs->parent('countries.index');
    $breadcrumbs->push('Details', route('countries.show', 0));
});

Breadcrumbs::for('countries.destroy', function ($breadcrumbs) {
    $breadcrumbs->push('Delete Country', route('countries.create'));
});

//State
Breadcrumbs::for('states.index', function ($breadcrumbs) {
    $breadcrumbs->parent('dashboard');
    $breadcrumbs->push('State', route('states.index'));
});

Breadcrumbs::for('states.create', function ($breadcrumbs) {
    $breadcrumbs->parent('states.index');
    $breadcrumbs->push('Create', route('states.create'));
});

Breadcrumbs::for('states.edit', function ($breadcrumbs) {
    $breadcrumbs->parent('states.index');
    $breadcrumbs->push('Edit', route('states.edit', 0));
});

Breadcrumbs::for('states.show', function ($breadcrumbs) {
    $breadcrumbs->parent('states.index');
    $breadcrumbs->push('Details', route('states.show', 0));
});

Breadcrumbs::for('states.destroy', function ($breadcrumbs) {
    $breadcrumbs->push('Delete State', route('states.create'));
});

//Cities
Breadcrumbs::for('cities.index', function ($breadcrumbs) {
    $breadcrumbs->parent('dashboard');
    $breadcrumbs->push('City', route('cities.index'));
});

Breadcrumbs::for('cities.create', function ($breadcrumbs) {
    $breadcrumbs->parent('cities.index');
    $breadcrumbs->push('Create', route('cities.create'));
});

Breadcrumbs::for('cities.edit', function ($breadcrumbs) {
    $breadcrumbs->parent('cities.index');
    $breadcrumbs->push('Edit', route('cities.edit', 0));
});

Breadcrumbs::for('cities.show', function ($breadcrumbs) {
    $breadcrumbs->parent('cities.index');
    $breadcrumbs->push('Details', route('cities.show', 0));
});

Breadcrumbs::for('cities.destroy', function ($breadcrumbs) {
    $breadcrumbs->push('Delete City', route('cities.create'));
});

//Vendors
Breadcrumbs::for('vendors.index', function ($breadcrumbs) {
    $breadcrumbs->parent('dashboard');
    $breadcrumbs->push('Vendor', route('vendors.index'));
});

Breadcrumbs::for('vendors.create', function ($breadcrumbs) {
    $breadcrumbs->parent('vendors.index');
    $breadcrumbs->push('Create', route('vendors.create'));
});

Breadcrumbs::for('vendors.edit', function ($breadcrumbs) {
    $breadcrumbs->parent('vendors.index');
    $breadcrumbs->push('Edit', route('vendors.edit', 0));
});

Breadcrumbs::for('vendors.show', function ($breadcrumbs) {
    $breadcrumbs->parent('vendors.index');
    $breadcrumbs->push('Details', route('vendors.show', 0));
});

Breadcrumbs::for('vendors.destroy', function ($breadcrumbs) {
    $breadcrumbs->push('Delete Vendor', route('vendors.create'));
});

// Course Chapters
Breadcrumbs::for('course-chapters.index', function ($breadcrumbs) {
    $breadcrumbs->parent('dashboard');
    $breadcrumbs->push('Course-chapters', route('course-chapters.index'));
});

Breadcrumbs::for('course-chapters.create', function ($breadcrumbs) {
    $breadcrumbs->parent('course-chapters.index');
    $breadcrumbs->push('Create', route('course-chapters.create'));
});

Breadcrumbs::for('course-chapters.edit', function ($breadcrumbs) {
    $breadcrumbs->parent('course-chapters.index');
    $breadcrumbs->push('Edit', route('course-chapters.edit', 0));
});

Breadcrumbs::for('course-chapters.show', function ($breadcrumbs) {
    $breadcrumbs->parent('course-chapters.index');
    $breadcrumbs->push('Details', route('course-chapters.show', 0));
});

Breadcrumbs::for('course-chapters.destroy', function ($breadcrumbs) {
    $breadcrumbs->push('Delete Course Chapter', route('course-chapters.create'));
});

// Course Class
Breadcrumbs::for('course-classes.index', function ($breadcrumbs) {
    $breadcrumbs->parent('dashboard');
    $breadcrumbs->push('Course-classes', route('course-classes.index'));
});

Breadcrumbs::for('course-classes.create', function ($breadcrumbs) {
    $breadcrumbs->parent('course-classes.index');
    $breadcrumbs->push('Create', route('course-classes.create'));
});

Breadcrumbs::for('course-classes.edit', function ($breadcrumbs) {
    $breadcrumbs->parent('course-classes.index');
    $breadcrumbs->push('Edit', route('course-classes.edit', 0));
});

Breadcrumbs::for('course-classes.show', function ($breadcrumbs) {
    $breadcrumbs->parent('course-classes.index');
    $breadcrumbs->push('Details', route('course-classes.show', 0));
});

Breadcrumbs::for('course-classes.destroy', function ($breadcrumbs) {
    $breadcrumbs->push('Delete Course Class', route('course-classes.create'));
});

// Course Question
Breadcrumbs::for('questions.index', function ($breadcrumbs) {
    $breadcrumbs->parent('dashboard');
    $breadcrumbs->push('questions', route('questions.index'));
});

Breadcrumbs::for('questions.create', function ($breadcrumbs) {
    $breadcrumbs->parent('questions.index');
    $breadcrumbs->push('Create', route('questions.create'));
});

Breadcrumbs::for('questions.edit', function ($breadcrumbs) {
    $breadcrumbs->parent('questions.index');
    $breadcrumbs->push('Edit', route('questions.edit', 0));
});

Breadcrumbs::for('questions.show', function ($breadcrumbs) {
    $breadcrumbs->parent('questions.index');
    $breadcrumbs->push('Details', route('questions.show', 0));
});

Breadcrumbs::for('questions.destroy', function ($breadcrumbs) {
    $breadcrumbs->push('Delete Course Question', route('questions.create'));
});
// Course Question Answer
Breadcrumbs::for('answers.index', function ($breadcrumbs) {
    $breadcrumbs->parent('dashboard');
    $breadcrumbs->push('answers', route('answers.index'));
});

Breadcrumbs::for('answers.create', function ($breadcrumbs) {
    $breadcrumbs->parent('answers.index');
    $breadcrumbs->push('Create', route('answers.create'));
});

Breadcrumbs::for('answers.edit', function ($breadcrumbs) {
    $breadcrumbs->parent('answers.index');
    $breadcrumbs->push('Edit', route('question-answers.edit', 0));
});

Breadcrumbs::for('answers.show', function ($breadcrumbs) {
    $breadcrumbs->parent('answers.index');
    $breadcrumbs->push('Details', route('answers.show', 0));
});

Breadcrumbs::for('answers.destroy', function ($breadcrumbs) {
    $breadcrumbs->push('Delete Answer', route('answers.create'));
});

// Course Syllabus
Breadcrumbs::for('course-syllabuses.index', function ($breadcrumbs) {
    $breadcrumbs->parent('dashboard');
    $breadcrumbs->push('course-syllabuses', route('course-syllabuses.index'));
});

Breadcrumbs::for('course-syllabuses.create', function ($breadcrumbs) {
    $breadcrumbs->parent('course-syllabuses.index');
    $breadcrumbs->push('Create', route('course-syllabuses.create'));
});

Breadcrumbs::for('course-syllabuses.edit', function ($breadcrumbs) {
    $breadcrumbs->parent('course-syllabuses.index');
    $breadcrumbs->push('Edit', route('course-syllabuses.edit', 0));
});

Breadcrumbs::for('course-syllabuses.show', function ($breadcrumbs) {
    $breadcrumbs->parent('course-syllabuses.index');
    $breadcrumbs->push('Details', route('course-syllabuses.show', 0));
});

Breadcrumbs::for('course-syllabuses.destroy', function ($breadcrumbs) {
    $breadcrumbs->push('Delete Syllabus', route('course-syllabuses.create'));
});

// Course Learn
Breadcrumbs::for('course-learns.index', function ($breadcrumbs) {
    $breadcrumbs->parent('dashboard');
    $breadcrumbs->push('course-learns', route('course-learns.index'));
});

Breadcrumbs::for('course-learns.create', function ($breadcrumbs) {
    $breadcrumbs->parent('course-learns.index');
    $breadcrumbs->push('Create', route('course-learns.create'));
});

Breadcrumbs::for('course-learns.edit', function ($breadcrumbs) {
    $breadcrumbs->parent('course-learns.index');
    $breadcrumbs->push('Edit', route('course-learns.edit', 0));
});

Breadcrumbs::for('course-learns.show', function ($breadcrumbs) {
    $breadcrumbs->parent('course-learns.index');
    $breadcrumbs->push('Details', route('course-learns.show', 0));
});

Breadcrumbs::for('course-learns.destroy', function ($breadcrumbs) {
    $breadcrumbs->push('Delete Learn', route('course-learns.create'));
});


// Quiz Topic
Breadcrumbs::for('quizzes.index', function ($breadcrumbs) {
    $breadcrumbs->parent('dashboard');
    $breadcrumbs->push('All Quizzes', route('quizzes.index'));
});

Breadcrumbs::for('quizzes.create', function ($breadcrumbs) {
    $breadcrumbs->parent('quizzes.index');
    $breadcrumbs->push('Quiz Topic Create', route('quizzes.create'));
});

Breadcrumbs::for('quizzes.edit', function ($breadcrumbs) {
    $breadcrumbs->parent('quizzes.index');
    $breadcrumbs->push('Quiz Topic Edit', route('quizzes.edit', 0));
});

Breadcrumbs::for('quizzes.show', function ($breadcrumbs) {
    $breadcrumbs->parent('quizzes.index');
    $breadcrumbs->push('Quiz Topic Details', route('quizzes.show', 0));
});

Breadcrumbs::for('quizzes.destroy', function ($breadcrumbs) {
    $breadcrumbs->push('Delete Quiz Topics', route('quizzes.create'));
});

//Course Assignments
Breadcrumbs::for('course-assignments.index', function ($breadcrumbs) {
    $breadcrumbs->parent('dashboard');
    $breadcrumbs->push('Course Assignments', route('course-assignments.index'));
});

Breadcrumbs::for('course-assignments.create', function ($breadcrumbs) {
    $breadcrumbs->parent('course-assignments.index');
    $breadcrumbs->push('Create', route('course-assignments.create'));
});

Breadcrumbs::for('course-assignments.edit', function ($breadcrumbs) {
    $breadcrumbs->parent('course-assignments.index');
    $breadcrumbs->push('Edit', route('course-assignments.edit', 0));
});

Breadcrumbs::for('course-assignments.show', function ($breadcrumbs) {
    $breadcrumbs->parent('course-assignments.index');
    $breadcrumbs->push('Details', route('course-assignments.show', 0));
});
Breadcrumbs::for('course-assignments.assignment-review', function ($breadcrumbs) {
    $breadcrumbs->parent('course-assignments.index');
    $breadcrumbs->push('Review', route('course-assignments.assignment-review', 0));
});

Breadcrumbs::for('course-assignments.destroy', function ($breadcrumbs) {
    $breadcrumbs->push('Delete Course Assignments', route('course-assignments.create'));
});

//Course Batches
Breadcrumbs::for('course-batches.index', function ($breadcrumbs) {
    $breadcrumbs->parent('dashboard');
    $breadcrumbs->push('Course Batches', route('course-batches.index'));
});

Breadcrumbs::for('course-batches.create', function ($breadcrumbs) {
    $breadcrumbs->parent('course-batches.index');
    $breadcrumbs->push('Create', route('course-batches.create'));
});

Breadcrumbs::for('course-batches.edit', function ($breadcrumbs) {
    $breadcrumbs->parent('course-batches.index');
    $breadcrumbs->push('Edit', route('course-batches.edit', 0));
});

Breadcrumbs::for('course-batches.show', function ($breadcrumbs) {
    $breadcrumbs->parent('course-batches.index');
    $breadcrumbs->push('Details', route('course-batches.show', 0));
});
Breadcrumbs::for('course-batches.destroy', function ($breadcrumbs) {
    $breadcrumbs->push('Delete Course Batches', route('course-batches.create'));
});

// Announcement Topic
Breadcrumbs::for('announcements.index', function ($breadcrumbs) {
    $breadcrumbs->parent('dashboard');
    $breadcrumbs->push('All Announcements', route('announcements.index'));
});

Breadcrumbs::for('announcements.create', function ($breadcrumbs) {
    $breadcrumbs->parent('announcements.index');
    $breadcrumbs->push('Announcement Create', route('announcements.create'));
});

Breadcrumbs::for('announcements.edit', function ($breadcrumbs) {
    $breadcrumbs->parent('announcements.index');
    $breadcrumbs->push('Announcement Edit', route('announcements.edit', 0));
});

Breadcrumbs::for('announcements.show', function ($breadcrumbs) {
    $breadcrumbs->parent('announcements.index');
    $breadcrumbs->push('Announcement Details', route('announcements.show', 0));
});

Breadcrumbs::for('announcements.destroy', function ($breadcrumbs) {
    $breadcrumbs->push('Delete Announcements', route('announcements.create'));
});

// Vendor Meetings
Breadcrumbs::for('vendor-meetings.index', function ($breadcrumbs) {
    $breadcrumbs->parent('dashboard');
    $breadcrumbs->push('All Vendor Meetings', route('vendor-meetings.index'));
});

Breadcrumbs::for('vendor-meetings.create', function ($breadcrumbs) {
    $breadcrumbs->parent('vendor-meetings.index');
    $breadcrumbs->push('Vendor Meeting Create', route('vendor-meetings.create'));
});

Breadcrumbs::for('vendor-meetings.edit', function ($breadcrumbs) {
    $breadcrumbs->parent('vendor-meetings.index');
    $breadcrumbs->push('Vendor Meeting Edit', route('vendor-meetings.edit', 0));
});

Breadcrumbs::for('vendor-meetings.show', function ($breadcrumbs) {
    $breadcrumbs->parent('vendor-meetings.index');
    $breadcrumbs->push('Vendor Meeting Details', route('vendor-meetings.show', 0));
});

Breadcrumbs::for('vendor-meetings.destroy', function ($breadcrumbs) {
    $breadcrumbs->push('Delete Vendor Meeting', route('vendor-meetings.create'));
});
// Course Rating
Breadcrumbs::for('course-ratings.index', function ($breadcrumbs) {
    $breadcrumbs->parent('dashboard');
    $breadcrumbs->push('All Course Ratings', route('course-ratings.index'));
});

Breadcrumbs::for('course-ratings.create', function ($breadcrumbs) {
    $breadcrumbs->parent('course-ratings.index');
    $breadcrumbs->push('Course Ratings Create', route('course-ratings.create'));
});

Breadcrumbs::for('course-ratings.edit', function ($breadcrumbs) {
    $breadcrumbs->parent('course-ratings.index');
    $breadcrumbs->push('Course Ratings Edit', route('course-ratings.edit', 0));
});

Breadcrumbs::for('course-ratings.show', function ($breadcrumbs) {
    $breadcrumbs->parent('course-ratings.index');
    $breadcrumbs->push('Course Ratings Details', route('course-ratings.show', 0));
});

Breadcrumbs::for('course-ratings.destroy', function ($breadcrumbs) {
    $breadcrumbs->push('Delete Course Ratings', route('course-ratings.create'));
});

// Banners Breadcumb List
Breadcrumbs::for('banners.index', function ($breadcrumbs) {
    $breadcrumbs->parent('dashboard');
    $breadcrumbs->push('All Banners', route('banners.index'));
});

Breadcrumbs::for('banners.create', function ($breadcrumbs) {
    $breadcrumbs->parent('banners.index');
    $breadcrumbs->push('Banner Create', route('banners.create'));
});

Breadcrumbs::for('banners.edit', function ($breadcrumbs) {
    $breadcrumbs->parent('banners.index');
    $breadcrumbs->push('Banner Edit', route('banners.edit', 0));
});

Breadcrumbs::for('banners.show', function ($breadcrumbs) {
    $breadcrumbs->parent('banners.index');
    $breadcrumbs->push("Banner's Details", route('banners.show', 0));
});

Breadcrumbs::for('banners.destroy', function ($breadcrumbs) {
    $breadcrumbs->push('Delete Banners', route('banners.create'));
});

// Result Manage
Breadcrumbs::for('results.index', function ($breadcrumbs) {
    $breadcrumbs->parent('dashboard');
    $breadcrumbs->push('results', route('results.index'));
});

Breadcrumbs::for('results.create', function ($breadcrumbs) {
    $breadcrumbs->parent('results.index');
    $breadcrumbs->push('Create', route('results.create'));
});

Breadcrumbs::for('results.edit', function ($breadcrumbs) {
    $breadcrumbs->parent('results.index');
    $breadcrumbs->push('Edit', route('results.edit', 0));
});

Breadcrumbs::for('results.show', function ($breadcrumbs) {
    $breadcrumbs->parent('results.index');
    $breadcrumbs->push('Details', route('results.show', 0));
});

Breadcrumbs::for('results.destroy', function ($breadcrumbs) {
    $breadcrumbs->push('Delete Result', route('results.create'));
});

// Enrollment Manage
Breadcrumbs::for('enrollments.index', function ($breadcrumbs) {
    $breadcrumbs->parent('dashboard');
    $breadcrumbs->push('enrollments', route('enrollments.index'));
});

Breadcrumbs::for('enrollments.create', function ($breadcrumbs) {
    $breadcrumbs->parent('enrollments.index');
    $breadcrumbs->push('Create', route('enrollments.create'));
});

Breadcrumbs::for('enrollments.edit', function ($breadcrumbs) {
    $breadcrumbs->parent('enrollments.index');
    $breadcrumbs->push('Edit', route('enrollments.edit', 0));
});

Breadcrumbs::for('enrollments.show', function ($breadcrumbs) {
    $breadcrumbs->parent('enrollments.index');
    $breadcrumbs->push('Details', route('enrollments.show', 0));
});

Breadcrumbs::for('enrollments.destroy', function ($breadcrumbs) {
    $breadcrumbs->push('Delete Enrollment', route('enrollments.create'));
});

// Book Rating Comment
Breadcrumbs::for('book-rating-comments.index', function ($breadcrumbs) {
    $breadcrumbs->parent('dashboard');
    $breadcrumbs->push('Book Rating Comment', route('book-rating-comments.index'));
});

Breadcrumbs::for('book-rating-comments.create', function ($breadcrumbs) {
    $breadcrumbs->parent('book-rating-comments.index');
    $breadcrumbs->push('Create', route('book-rating-comments.create'));
});

Breadcrumbs::for('book-rating-comments.edit', function ($breadcrumbs) {
    $breadcrumbs->parent('book-rating-comments.index');
    $breadcrumbs->push('Edit', route('book-rating-comments.edit', 0));
});

Breadcrumbs::for('book-rating-comments.show', function ($breadcrumbs) {
    $breadcrumbs->parent('book-rating-comments.index');
    $breadcrumbs->push('Details', route('book-rating-comments.show', 0));
});

Breadcrumbs::for('book-rating-comments.destroy', function ($breadcrumbs) {
    $breadcrumbs->push('Delete Book Rating Comment', route('book-rating-comments.create'));
});

// coupons Breadcumb List
Breadcrumbs::for('coupons.index', function ($breadcrumbs) {
    $breadcrumbs->parent('dashboard');
    $breadcrumbs->push('All Coupons', route('coupons.index'));
});

Breadcrumbs::for('coupons.create', function ($breadcrumbs) {
    $breadcrumbs->parent('coupons.index');
    $breadcrumbs->push('Coupon Create', route('coupons.create'));
});

Breadcrumbs::for('coupons.edit', function ($breadcrumbs) {
    $breadcrumbs->parent('coupons.index');
    $breadcrumbs->push('Coupon Edit', route('coupons.edit', 0));
});

Breadcrumbs::for('coupons.show', function ($breadcrumbs) {
    $breadcrumbs->parent('coupons.index');
    $breadcrumbs->push("Coupon's Details", route('coupons.show', 0));
});

Breadcrumbs::for('coupons.destroy', function ($breadcrumbs) {
    $breadcrumbs->push('Delete Coupons', route('coupons.create'));
});

// Blogs
Breadcrumbs::for('blogs.index', function ($breadcrumbs) {
    $breadcrumbs->parent('dashboard');
    $breadcrumbs->push('All Blogs', route('blogs.index'));
});

Breadcrumbs::for('blogs.create', function ($breadcrumbs) {
    $breadcrumbs->parent('blogs.index');
    $breadcrumbs->push('Coupon Create', route('blogs.create'));
});

Breadcrumbs::for('blogs.edit', function ($breadcrumbs) {
    $breadcrumbs->parent('blogs.index');
    $breadcrumbs->push('Coupon Edit', route('blogs.edit', 0));
});

Breadcrumbs::for('blogs.show', function ($breadcrumbs) {
    $breadcrumbs->parent('blogs.index');
    $breadcrumbs->push("Coupon's Details", route('blogs.show', 0));
});

Breadcrumbs::for('blogs.destroy', function ($breadcrumbs) {
    $breadcrumbs->push('Delete blogs', route('blogs.create'));
});

// Orders
Breadcrumbs::for('transactions.index', function ($breadcrumbs) {
    $breadcrumbs->parent('dashboard');
    $breadcrumbs->push('All Transactions', route('transactions.index'));
});

Breadcrumbs::for('transactions.create', function ($breadcrumbs) {
    $breadcrumbs->parent('transactions.index');
    $breadcrumbs->push('Order Create', route('transactions.create'));
});

Breadcrumbs::for('transactions.edit', function ($breadcrumbs) {
    $breadcrumbs->parent('transactions.index');
    $breadcrumbs->push('Order Edit', route('transactions.edit', 0));
});

Breadcrumbs::for('transactions.show', function ($breadcrumbs) {
    $breadcrumbs->parent('transactions.index');
    $breadcrumbs->push("Order Details", route('transactions.show', 0));
});

Breadcrumbs::for('transactions.destroy', function ($breadcrumbs) {
    $breadcrumbs->push('Delete Transaction', route('transactions.create'));
});

Breadcrumbs::for('transactions.status', function ($trail, $transaction_id) {
    $trail->push('Transaction Status', route('transactions.status', $transaction_id));
});


//faq
Breadcrumbs::for('faq.index', function ($breadcrumbs) {
    $breadcrumbs->parent('dashboard');
    $breadcrumbs->push('FAQ', route('faq.index'));
});

Breadcrumbs::for('faq.create', function ($breadcrumbs) {
    $breadcrumbs->parent('faq.index');
    $breadcrumbs->push('Create', route('faq.create'));
});

Breadcrumbs::for('faq.edit', function ($breadcrumbs) {
    $breadcrumbs->parent('faq.index');
    $breadcrumbs->push('Edit', route('faq.edit', 0));
});

Breadcrumbs::for('faq.show', function ($breadcrumbs) {
    $breadcrumbs->parent('faq.index');
    $breadcrumbs->push('Details', route('faq.show', 0));
});

Breadcrumbs::for('faq.destroy', function (BreadcrumbTrail $breadcrumbs) {
    $breadcrumbs->push('Delete Faq', route('faq.create'));
});

//book price list
Breadcrumbs::for('bookpricelist.index', function ($breadcrumbs) {
    $breadcrumbs->parent('dashboard');
    $breadcrumbs->push('Book Price List', route('bookpricelist.index'));
});

Breadcrumbs::for('bookpricelist.create', function ($breadcrumbs) {
    $breadcrumbs->parent('bookpricelist.index');
    $breadcrumbs->push('Create', route('bookpricelist.create'));
});

Breadcrumbs::for('bookpricelist.edit', function ($breadcrumbs) {
    $breadcrumbs->parent('bookpricelist.index');
    $breadcrumbs->push('Edit', route('bookpricelist.edit', 0));
});

Breadcrumbs::for('bookpricelist.show', function ($breadcrumbs) {
    $breadcrumbs->parent('bookpricelist.index');
    $breadcrumbs->push('Details', route('bookpricelist.show', 0));
});

Breadcrumbs::for('bookpricelist.destroy', function (BreadcrumbTrail $breadcrumbs) {
    $breadcrumbs->push('Delete Book Price List', route('bookpricelist.create'));
});

//branch location
Breadcrumbs::for('branchlocation.index', function ($breadcrumbs) {
    $breadcrumbs->parent('dashboard');
    $breadcrumbs->push('Branch Location', route('branchlocation.index'));
});

Breadcrumbs::for('branchlocation.create', function ($breadcrumbs) {
    $breadcrumbs->parent('branchlocation.index');
    $breadcrumbs->push('Create', route('branchlocation.create'));
});

Breadcrumbs::for('branchlocation.edit', function ($breadcrumbs) {
    $breadcrumbs->parent('branchlocation.index');
    $breadcrumbs->push('Edit', route('branchlocation.edit', 0));
});

Breadcrumbs::for('branchlocation.show', function ($breadcrumbs) {
    $breadcrumbs->parent('branchlocation.index');
    $breadcrumbs->push('Details', route('branchlocation.show', 0));
});

Breadcrumbs::for('branchlocation.destroy', function (BreadcrumbTrail $breadcrumbs) {
    $breadcrumbs->push('Delete Branch Location', route('branchlocation.create'));
});

//googleApiKey
Breadcrumbs::for('googleApiKey.index', function ($breadcrumbs) {
    $breadcrumbs->parent('dashboard');
    $breadcrumbs->push('Google Api Key', route('googleApiKey.index'));
});

Breadcrumbs::for('googleApiKey.create', function ($breadcrumbs) {
    $breadcrumbs->parent('googleApiKey.index');
    $breadcrumbs->push('Create', route('googleApiKey.create'));
});

Breadcrumbs::for('googleApiKey.edit', function ($breadcrumbs) {
    $breadcrumbs->parent('googleApiKey.index');
    $breadcrumbs->push('Edit', route('googleApiKey.edit', 0));
});

Breadcrumbs::for('googleApiKey.show', function ($breadcrumbs) {
    $breadcrumbs->parent('googleApiKey.index');
    $breadcrumbs->push('Details', route('googleApiKey.show', 0));
});

Breadcrumbs::for('googleApiKey.destroy', function (BreadcrumbTrail $breadcrumbs) {
    $breadcrumbs->push('Delete Google Api Key', route('googleApiKey.create'));
});

Breadcrumbs::for('changePasswordGet', function ($breadcrumbs) {
    $breadcrumbs->push('Create', route('changePasswordGet'));
});