<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Models\Category;
use App\Models\Equipment;
use App\Models\Setting;
use App\Models\Booking;
use App\Models\User;
use Illuminate\Http\Request;

class HomeController extends Controller
{
    public function index()
    {
        $categories = Category::active()->with('equipment')->get();
        $featuredEquipment = Equipment::active()->available()->take(6)->get();
        $settings = Setting::getGroup('hero');
        
        // Statistics
        $totalEquipment = Equipment::active()->count();
        $totalBookings = Booking::where('status', 'completed')->count();
        $totalUsers = User::where('role', 'user')->count();
        
        // Company info from settings
        $companySettings = Setting::getGroup('company');
        $companyName = $companySettings['company_name'] ?? 'Rental Alat Berat';
        $companyAddress = $companySettings['company_address'] ?? null;
        $companyPhone = $companySettings['company_phone'] ?? null;
        $companyEmail = $companySettings['company_email'] ?? null;
        
        $aboutSettings = Setting::getGroup('about');
        $aboutText = $aboutSettings['about_text'] ?? null;
        
        return view('home', compact(
            'categories', 
            'featuredEquipment', 
            'settings',
            'totalEquipment',
            'totalBookings', 
            'totalUsers',
            'companyName',
            'companyAddress',
            'companyPhone',
            'companyEmail',
            'aboutText'
        ));
    }

    public function about()
    {
        $settings = Setting::getGroup('about');
        return view('about', compact('settings'));
    }

    public function visionMission()
    {
        $settings = Setting::getGroup('vision_mission');
        return view('vision-mission', compact('settings'));
    }

    public function contact()
    {
        $settings = Setting::getGroup('company');
        return view('contact', compact('settings'));
    }
}
