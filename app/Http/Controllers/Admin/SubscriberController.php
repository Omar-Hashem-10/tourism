<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\NewsletterSubscriber;
use Illuminate\Http\Request;

class SubscriberController extends Controller
{
    public function index(Request $request)
    {
        $query = NewsletterSubscriber::query();

        if ($request->filled('search')) {
            $query->where('email', 'like', '%' . $request->search . '%');
        }

        $subscribers = $query->latest()->paginate(20)->withQueryString();

        return view('admin.subscribers.index', compact('subscribers'));
    }

    public function exportCsv()
    {
        return response()->streamDownload(function () {
            $handle = fopen('php://output', 'w');
            fprintf($handle, chr(0xEF) . chr(0xBB) . chr(0xBF)); // UTF-8 BOM
            fputcsv($handle, ['البريد الإلكتروني', 'تاريخ الاشتراك', 'الحالة']);

            NewsletterSubscriber::chunk(200, function ($rows) use ($handle) {
                foreach ($rows as $row) {
                    fputcsv($handle, [
                        $row->email,
                        $row->created_at->format('Y-m-d'),
                        $row->is_active ? 'نشط' : 'غير نشط',
                    ]);
                }
            });

            fclose($handle);
        }, 'subscribers_' . now()->format('Ymd') . '.csv', [
            'Content-Type' => 'text/csv; charset=UTF-8',
        ]);
    }

    public function destroy(NewsletterSubscriber $subscriber)
    {
        $subscriber->delete();
        return back()->with('success', 'تم حذف المشترك.');
    }
}
