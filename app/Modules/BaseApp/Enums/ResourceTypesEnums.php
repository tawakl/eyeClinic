<?php

declare(strict_types = 1);

namespace App\Modules\BaseApp\Enums;

abstract class ResourceTypesEnums
{
    public const SUBJECT = 'subject',
        COURSE = 'course',
        USER = 'user',
        RESET_PASSWORD = 'reset_password',
        RATING = 'rating',
        ACTION = 'action',
        COUNTRY = 'country',
        MEDIA = 'media',
        TASK = 'task',
        INSTRUCTOR = 'instructor',
        LOOKUP = 'look_up',
        TRANSACTION = 'transaction',
        STATISTICS = 'statistics',
        COURSE_SESSION = 'course_session',
        RESOURCE_TYPE = 'resource_type',
        GARBAGE_MEDIA = 'garbage_media',
        PRICE_SORT_KEY = 'price_sort_key',
        USER_PROMO_CODE = 'user_promo_code',
        CANCEL_USER_PROMO_CODE = 'cancel_user_promo_code',
        VCR_SESSION = 'vcr_session',
        VCR_RECORD = 'vcr_record',
        RATING_DETAILS = 'rating_details',
        TESTIMONIAL = 'testimonial',
        RATE_SORT_KEY = 'rate_sort_key',
        COURSE_MEDIA = 'course_media',
        COURSE_DISCUSSION = 'course_discussion',
        DISCUSSION_COMMENTS = 'discussion_comments',
        STUDENT = 'student',
        EXAM = 'exam',
        QUESTION = 'question',
        STUDENT_EXAM = 'student_exam',
        STUDENT_ANSWER = 'student_answer',
        PROMO_CODE = 'promo_code',
        STATIC_CONTENT = 'static_content',
        CONFIG = 'config',
        CHOICE = 'choice',
        NOTIFICATION = 'notification',
        BLOG = 'blog',
        VIEW_BLOG = 'view_blog',
        SCHOOL = 'school';
}
