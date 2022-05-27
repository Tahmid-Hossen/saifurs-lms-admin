<?php

namespace App\Repositories\Backend\CourseManage;

use App\Models\Backend\Course\CourseProgress;
use App\Repositories\Repository;

class CourseProgressRepository extends Repository
{

    /**
     * @return string
     */
    public function model(): string
    {
        return CourseProgress::class;
    }

    public function courseProgressFilterData($filters)
    {
        $query = $this->model->sortable()->newQuery();
        $query->leftJoin('course_classes', 'course_classes.id', '=', 'course_progresses.course_class_id');
        $query->leftJoin('course_chapters', 'course_chapters.id', '=', 'course_classes.chapter_id');
        $query->leftJoin('course', 'course.id', '=', 'course_chapters.course_id');
        $query->leftJoin('users AS students', 'students.id', '=', 'course_progresses.student_id');
        $query->leftJoin('user_details AS student_details', 'student_details.user_id', '=', 'students.id');

        if (isset($filters['id']) && $filters['id']) {
            $query->where('course_progresses.id', '=', $filters['id']);
        }

        if (isset($filters['search_text']) && $filters['search_text']) {
            $query->Where(function ($queryString) use ($filters) {
                $queryString->Where('course.course_title', 'like', "%{$filters['search_text']}%");
                $queryString->orWhere('course_chapters.chapter_title', 'like', "%{$filters['search_text']}%");
                $queryString->orWhere('course_classes.class_name', 'like', "%{$filters['search_text']}%");
                $queryString->orWhere('students.name', 'like', "%{$filters['search_text']}%");
            });
        }

        if (isset($filters['course_id']) && $filters['course_id']) {
            $query->where('course.id', '=', $filters['course_id']);
        }

        if (isset($filters['course_chapter_id']) && $filters['course_chapter_id']) {
            $query->where('course_chapters.id', '=', $filters['course_chapter_id']);
        }

        if (isset($filters['course_class_id']) && $filters['course_class_id']) {
            $query->where('course_progresses.course_class_id', '=', $filters['course_class_id']);
        }

        if (isset($filters['student_id']) && $filters['student_id']) {
            $query->where('course_progresses.student_id', '=', $filters['student_id']);
        }

        $query->whereNull('course.deleted_at');
        $query->whereNull('course_chapters.deleted_at');
        $query->whereNull('course_classes.deleted_at');

        $query->select([
            'students.name AS student_name', 'students.mobile_number AS student_mobile_number', 'students.email AS student_email',
            'student_details.first_name AS student_detail_first_name', 'student_details.last_name AS student_last_name',
            \DB::raw('IFNULL(IF(student_details.user_detail_photo REGEXP "https?", student_details.user_detail_photo, CONCAT("'.url('/').'",student_details.user_detail_photo)), CONCAT("'.url('/').'","/assets/img/user-default.png")) AS student_detail_photo'),
            'course.course_title', \DB::raw('IFNULL(IF(course.course_image REGEXP "https?", course.course_image, CONCAT("'.url('/').'",course.course_image)), CONCAT("'.url('/').'","/assets/img/default.png")) AS course_image'),
            'course_chapters.chapter_title', 'course_classes.class_name',
            \DB::raw('CONVERT_TZ(course_progresses.created_at, "+00:00", "+06:00") AS created_at')
        ]);
        return $query;
    }
}
