<?php

namespace App\Services;

use App\Models\Notification;
use App\Models\User;

class NotificationService
{
    public static function createForUser(User $user, string $title, string $message, string $type = 'info', array $data = [])
    {
        return Notification::create([
            'user_id' => $user->id,
            'title' => $title,
            'message' => $message,
            'type' => $type,
            'data' => $data,
        ]);
    }

    public static function notifyEnrollmentStatusChange(User $user, string $status)
    {
        $titles = [
            'approved' => '🎉 Enrollment Approved!',
            'rejected' => '❌ Enrollment Rejected',
            'pending' => '⏳ Enrollment Under Review',
        ];

        $messages = [
            'approved' => 'Congratulations! Your enrollment has been approved. You can now access all student features.',
            'rejected' => 'Your enrollment has been rejected. Please contact the registrar for more information.',
            'pending' => 'Your enrollment is currently under review. We will notify you once a decision is made.',
        ];

        $types = [
            'approved' => 'success',
            'rejected' => 'error',
            'pending' => 'info',
        ];

        return self::createForUser(
            $user,
            $titles[$status] ?? 'Enrollment Status Update',
            $messages[$status] ?? 'Your enrollment status has been updated.',
            $types[$status] ?? 'info',
            ['enrollment_status' => $status]
        );
    }

    public static function notifyDocumentUpload(User $user, string $documentType)
    {
        return self::createForUser(
            $user,
            '📄 Document Uploaded Successfully',
            "Your {$documentType} has been uploaded successfully and is now under review.",
            'success',
            ['document_type' => $documentType]
        );
    }

    public static function notifySystemAnnouncement(User $user, string $title, string $message)
    {
        return self::createForUser(
            $user,
            "📢 {$title}",
            $message,
            'info',
            ['type' => 'announcement']
        );
    }

    public static function notifyAllStudents($title, $message)
    {
        $students = User::where('role', 'student')->get();
        
        foreach ($students as $student) {
            self::createForUser($student, $title, $message, 'announcement');
        }
    }

    public static function notifyUsersByRole($role, $title, $message)
    {
        $users = User::where('role', $role)->get();
        
        foreach ($users as $user) {
            self::createForUser($user, $title, $message, 'announcement');
        }
    }

    public static function notifyAllUsers($title, $message)
    {
        $users = User::all();
        
        foreach ($users as $user) {
            self::createForUser($user, $title, $message, 'announcement');
        }
    }
}