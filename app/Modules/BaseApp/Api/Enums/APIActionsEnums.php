<?php

declare(strict_types = 1);

namespace App\Modules\BaseApp\Api\Enums;

abstract class APIActionsEnums
{
    /**
     * List of all buttons action in the api endpoints
     *
     * Please note that the following keys should not be modified because it may break the mobile app
     * Please not that the following keys should not be modified because it may break the mobile app
     */
    public const
        VIEW_COURSE = 'view_course',
        LOOKUP = 'lookup',
        CANCEL_USER_PROMO_CODE = 'cancel_user_promo_code',
        JOIN = 'join',
        START_SESSION = 'start_session',
        VIEW_COURSE_SESSION = 'view_course_session',
        COURSE_RATE = 'course_rate',
        SUBSCRIBE_COURSE = 'subscribe_course',
        APPLY_PROMO_CODE = 'apply_promo_code',
        ATTACH_MEDIA = 'attach_media',
        DETACH_MEDIA = 'detach_media',
        UPDATE_PROFILE = 'update_profile',
        UPDATE_PASSWORD = 'update_password',
        DOWNLOAD_MEDIA = 'download_media',
        ADD_COURSE_DISCUSSION = 'add_course_discussion',
        ADD_COURSE_DISCUSSION_COMMENT = 'add_course_discussion_comment',
        UPDATE_COURSE_DISCUSSION = 'update_course_discussion',
        DELETE_COURSE_DISCUSSION = 'delete_course_discussion',
        ACTIVATE_STUDENT_COURSE = 'activate_student_course',
        INSTRUCTOR_DELETE_DISCUSSION = 'instructor_delete_discussion',
        UPDATE_COURSE_DISCUSSION_COMMENT = 'update_course_discussion_comment',
        DELETE_COURSE_DISCUSSION_COMMENT = 'delete_course_discussion_comment',
        INSTRUCTOR_DELETE_DISCUSSION_COMMENT = 'instructor_delete_discussion_comment',
        LIKE_COURSE_DISCUSSION_COMMENT = 'like_course_discussion_comment',
        DISLIKE_COURSE_DISCUSSION_COMMENT = 'dislike_course_discussion_comment',
        REPLY_COURSE_DISCUSSION_COMMENT = 'reply_course_discussion_comment',
        LIKE_COURSE_DISCUSSION = 'like_course_discussion',
        DISLIKE_COURSE_DISCUSSION = 'dislike_course_discussion',
        PUBLISH_EXAM = 'publish_exam',
        EDIT_EXAM = 'edit_exam',
        SHOW_EXAM = 'show_exam',
        DELETE_EXAM_QUESTIONS = 'delete_exam_questions',
        ADD_EXAM_QUESTIONS = 'add_exam_questions',
        LIST_COURSE_MEDIA = 'list_course_media',
        START_EXAM = 'start_exam',
        EXAM_REPORT = 'exam_report',
        SUBMIT_ANSWER = 'submit_answer',
        FINISH_EXAM = 'finish_exam',
        LIST_EXAM_STUDENTS = 'list_exam_students',
        LIST_COURSE_DISCUSSION = 'list_course_discussion',
        LIST_COURSE_STUDENTS = 'list_course_students',
        LIST_COURSE_DISCUSSION_COMMENTS = 'list_course_discussion_comments',
        MARK_NOTIFICATION_AS_READ = 'mark_notification_as_read',
        STUDENT_VIEW_COURSE = 'student_view_course',
        INSTRUCTOR_VIEW_COURSE = 'instructor_view_course',
        VIEW_TELEGRAM = 'view_telegram',
        VIEW_COURSE_DISCUSSION = 'view_course_discussion',
        DELETE_ACCOUNT = 'delete_account',
        VIEW_BLOG = 'view_blog',
        CREATE_EXAM = 'create_exam';
}
