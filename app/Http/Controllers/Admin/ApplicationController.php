<?php

namespace App\Http\Controllers\Admin;

use App\Models\Application;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\View\View;

class ApplicationController
{

    public function application(Request $request): View
    {
        $items = Application::query()->where('type', 'application')->orderBy('created_at', 'desc')->paginate($request->input('per_page', 20));
        return view('admin.application.application', compact('items'));
    }

    public function order(Request $request): View
    {
        $items = Application::query()->where('type', 'order')->orderBy('created_at', 'desc')->paginate($request->input('per_page', 20));
        return view('admin.application.order', compact('items'));
    }

    public function delete(Application $application): RedirectResponse
    {
        $application->delete();
        return redirect()->back()->with('success', 'Успешно удален');
    }
}
