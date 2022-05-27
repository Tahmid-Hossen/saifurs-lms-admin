<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Route;
use Spatie\Permission\Models\Permission;

class PermissionSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $routes = array_keys(Route::getRoutes()->getRoutesByName());

        $output = new \Symfony\Component\Console\Output\ConsoleOutput();
        //Ajax Routes
        $excludeRoutes = [
            'v1.',
            'branches.get-branch-list',
            'course-categories.get-course-category-list',
            'course-sub-categories.get-course-sub-category-list',
            'course.get-course-list',
            'course.get-course-chapter-list',
            'teachers.get-teacher-list',
            'students.get-student-list',
            'course-listview.get',
            'user-details.get-user-detail-list',
            'debugbar.',
            'telescope.',
            'passport.',
        ];

        foreach ($routes as $route):
            foreach ($excludeRoutes as $excludeRoute):
                //$output->writeln('Pattern :' . $excludeRoute. " Result: " . var_dump(stripos($route, $excludeRoute)));
                if (stripos($route, $excludeRoute) === false) :
                    try {
                        $temp = Permission::firstOrCreate(['name' => $route]);
                    } catch (\PDOException $exception) {
                        throw new \PDOException($exception->getMessage());
                    }
                endif;
            endforeach;
        endforeach;
    }
}
