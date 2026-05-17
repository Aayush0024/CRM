<?php

namespace Database\Seeders;

use App\Models\Activity;
use App\Models\Contact;
use App\Models\Customer;
use App\Models\Deal;
use App\Models\Lead;
use App\Models\Notification;
use App\Models\Role;
use App\Models\Setting;
use App\Models\Tag;
use App\Models\Task;
use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class DatabaseSeeder extends Seeder
{
    public function run(): void
    {
        // Roles
        $adminRole = Role::create([
            'name'         => 'admin',
            'display_name' => 'Administrator',
            'description'  => 'Full access — create users, assign roles, reset passwords, disable accounts, view reports, configure CRM',
        ]);
        $managerRole = Role::create([
            'name'         => 'sales_manager',
            'display_name' => 'Sales Manager',
            'description'  => 'Manage team leads, assign deals, view team reports',
        ]);
        $agentRole = Role::create([
            'name'         => 'sales_executive',
            'display_name' => 'Sales Executive',
            'description'  => 'View own leads, manage own deals, update own tasks',
        ]);
        $supportRole = Role::create([
            'name'         => 'support_agent',
            'display_name' => 'Support Agent',
            'description'  => 'Handle customer issues, create notes and tasks',
        ]);

        // Users
        $admin = User::create([
            'name' => 'Admin User',
            'email' => 'admin@crm.com',
            'password' => Hash::make('password'),
            'role_id' => $adminRole->id,
            'language_preference' => 'en',
            'is_active' => true,
        ]);

        $manager = User::create([
            'name'                => 'Rajesh Kumar',
            'email'               => 'rajesh@crm.com',
            'password'            => Hash::make('password'),
            'role_id'             => $managerRole->id,
            'language_preference' => 'hi',
            'is_active'           => true,
        ]);

        $agent1 = User::create([
            'name'                => 'Priya Sharma',
            'email'               => 'priya@crm.com',
            'password'            => Hash::make('password'),
            'role_id'             => $agentRole->id,
            'language_preference' => 'hi',
            'is_active'           => true,
        ]);

        $agent2 = User::create([
            'name'                => 'Arjun Nair',
            'email'               => 'arjun@crm.com',
            'password'            => Hash::make('password'),
            'role_id'             => $agentRole->id,
            'language_preference' => 'ml',
            'is_active'           => true,
        ]);

        $support = User::create([
            'name'                => 'Sunita Rao',
            'email'               => 'sunita@crm.com',
            'password'            => Hash::make('password'),
            'role_id'             => $supportRole->id,
            'language_preference' => 'te',
            'is_active'           => true,
        ]);

        // Tags
        $tags = collect(['VIP', 'Enterprise', 'SME', 'Startup', 'Government', 'Education'])->map(fn($name) => Tag::create(['name' => $name]));

        // Settings
        Setting::create(['key' => 'company_name', 'value' => 'Regional CRM Solutions']);
        Setting::create(['key' => 'company_email', 'value' => 'info@regionalcrm.com']);
        Setting::create(['key' => 'default_language', 'value' => 'en']);
        Setting::create(['key' => 'default_currency', 'value' => 'INR']);

        // Customers with regional language preferences
        $customersData = [
            ['name' => 'Tata Consultancy Services', 'company' => 'TCS', 'email' => 'contact@tcs.com', 'phone' => '+91-22-67789999', 'city' => 'Mumbai', 'state' => 'Maharashtra', 'status' => 'active', 'preferred_language' => 'mr', 'industry' => 'IT Services'],
            ['name' => 'Infosys Limited', 'company' => 'Infosys', 'email' => 'info@infosys.com', 'phone' => '+91-80-28520261', 'city' => 'Bengaluru', 'state' => 'Karnataka', 'status' => 'active', 'preferred_language' => 'kn', 'industry' => 'IT Services'],
            ['name' => 'Wipro Technologies', 'company' => 'Wipro', 'email' => 'contact@wipro.com', 'phone' => '+91-80-28440011', 'city' => 'Bengaluru', 'state' => 'Karnataka', 'status' => 'active', 'preferred_language' => 'kn', 'industry' => 'IT Services'],
            ['name' => 'Reliance Industries', 'company' => 'RIL', 'email' => 'info@ril.com', 'phone' => '+91-22-44779000', 'city' => 'Mumbai', 'state' => 'Maharashtra', 'status' => 'active', 'preferred_language' => 'hi', 'industry' => 'Conglomerate'],
            ['name' => 'Mahindra & Mahindra', 'company' => 'M&M', 'email' => 'contact@mahindra.com', 'phone' => '+91-22-24901441', 'city' => 'Mumbai', 'state' => 'Maharashtra', 'status' => 'active', 'preferred_language' => 'mr', 'industry' => 'Automotive'],
            ['name' => 'Chennai Silks', 'company' => 'Chennai Silks', 'email' => 'info@chennaisilks.com', 'phone' => '+91-44-28140000', 'city' => 'Chennai', 'state' => 'Tamil Nadu', 'status' => 'prospect', 'preferred_language' => 'ta', 'industry' => 'Retail'],
            ['name' => 'Kerala Ayurveda Ltd', 'company' => 'Kerala Ayurveda', 'email' => 'info@keralaayurveda.com', 'phone' => '+91-484-2345678', 'city' => 'Kochi', 'state' => 'Kerala', 'status' => 'active', 'preferred_language' => 'ml', 'industry' => 'Healthcare'],
            ['name' => 'Amul Dairy', 'company' => 'GCMMF', 'email' => 'info@amul.com', 'phone' => '+91-2692-258506', 'city' => 'Anand', 'state' => 'Gujarat', 'status' => 'active', 'preferred_language' => 'gu', 'industry' => 'Food & Beverage'],
            ['name' => 'Haldirams Snacks', 'company' => 'Haldirams', 'email' => 'contact@haldirams.com', 'phone' => '+91-11-23456789', 'city' => 'Delhi', 'state' => 'Delhi', 'status' => 'prospect', 'preferred_language' => 'hi', 'industry' => 'Food & Beverage'],
            ['name' => 'Muthoot Finance', 'company' => 'Muthoot', 'email' => 'info@muthoot.com', 'phone' => '+91-484-6690000', 'city' => 'Kochi', 'state' => 'Kerala', 'status' => 'active', 'preferred_language' => 'ml', 'industry' => 'Finance'],
        ];

        $customers = [];
        foreach ($customersData as $i => $data) {
            $customer = Customer::create(array_merge($data, [
                'country' => 'India',
                'source' => ['website', 'referral', 'cold_call', 'event'][rand(0, 3)],
                'assigned_to' => [$agent1->id, $agent2->id, $manager->id][rand(0, 2)],
                'created_by' => $admin->id,
            ]));
            $customer->tags()->attach($tags->random(rand(1, 2))->pluck('id'));
            $customers[] = $customer;
        }

        // Contacts
        $contactsData = [
            ['first_name' => 'Suresh', 'last_name' => 'Patel', 'email' => 'suresh@tcs.com', 'phone' => '+91-9876543210', 'job_title' => 'CTO', 'preferred_language' => 'gu'],
            ['first_name' => 'Anita', 'last_name' => 'Krishnan', 'email' => 'anita@infosys.com', 'phone' => '+91-9876543211', 'job_title' => 'VP Sales', 'preferred_language' => 'ta'],
            ['first_name' => 'Vikram', 'last_name' => 'Singh', 'email' => 'vikram@wipro.com', 'phone' => '+91-9876543212', 'job_title' => 'Director', 'preferred_language' => 'hi'],
            ['first_name' => 'Meera', 'last_name' => 'Nambiar', 'email' => 'meera@muthoot.com', 'phone' => '+91-9876543213', 'job_title' => 'CFO', 'preferred_language' => 'ml'],
            ['first_name' => 'Ravi', 'last_name' => 'Shankar', 'email' => 'ravi@amul.com', 'phone' => '+91-9876543214', 'job_title' => 'MD', 'preferred_language' => 'gu'],
        ];

        foreach ($contactsData as $i => $data) {
            Contact::create(array_merge($data, [
                'customer_id' => $customers[$i]->id,
                'created_by' => $admin->id,
            ]));
        }

        // Leads
        $leadsData = [
            ['title' => 'ERP Implementation Project', 'name' => 'Deepak Mehta', 'email' => 'deepak@startup.com', 'company' => 'TechStart India', 'status' => 'qualified', 'priority' => 'high', 'estimated_value' => 1500000, 'source' => 'referral', 'preferred_language' => 'hi'],
            ['title' => 'Cloud Migration Services', 'name' => 'Kavitha Rajan', 'email' => 'kavitha@corp.com', 'company' => 'South Corp Ltd', 'status' => 'contacted', 'priority' => 'medium', 'estimated_value' => 800000, 'source' => 'website', 'preferred_language' => 'ta'],
            ['title' => 'Mobile App Development', 'name' => 'Arun Kumar', 'email' => 'arun@business.com', 'company' => 'Kerala Business', 'status' => 'new', 'priority' => 'low', 'estimated_value' => 350000, 'source' => 'social_media', 'preferred_language' => 'ml'],
            ['title' => 'Digital Marketing Campaign', 'name' => 'Pooja Gupta', 'email' => 'pooja@retail.com', 'company' => 'Delhi Retail', 'status' => 'qualified', 'priority' => 'high', 'estimated_value' => 250000, 'source' => 'cold_call', 'preferred_language' => 'hi'],
            ['title' => 'HR Software License', 'name' => 'Ramesh Babu', 'email' => 'ramesh@mfg.com', 'company' => 'AP Manufacturing', 'status' => 'contacted', 'priority' => 'medium', 'estimated_value' => 600000, 'source' => 'event', 'preferred_language' => 'te'],
        ];

        foreach ($leadsData as $data) {
            Lead::create(array_merge($data, [
                'currency' => 'INR',
                'customer_id' => $customers[rand(0, count($customers) - 1)]->id,
                'assigned_to' => [$agent1->id, $agent2->id][rand(0, 1)],
                'created_by' => $admin->id,
                'expected_close_date' => now()->addDays(rand(30, 90)),
            ]));
        }

        // Deals
        $dealsData = [
            ['title' => 'TCS Annual Software License', 'value' => 5000000, 'stage' => 'negotiation', 'probability' => 75],
            ['title' => 'Infosys Cloud Infrastructure', 'value' => 3200000, 'stage' => 'proposal', 'probability' => 50],
            ['title' => 'Wipro Security Audit', 'value' => 1800000, 'stage' => 'qualification', 'probability' => 30],
            ['title' => 'Reliance Data Analytics', 'value' => 7500000, 'stage' => 'closed_won', 'probability' => 100],
            ['title' => 'Mahindra Fleet Management', 'value' => 2100000, 'stage' => 'prospecting', 'probability' => 20],
            ['title' => 'Amul Supply Chain System', 'value' => 4200000, 'stage' => 'negotiation', 'probability' => 80],
        ];

        foreach ($dealsData as $i => $data) {
            Deal::create(array_merge($data, [
                'currency' => 'INR',
                'status' => $data['stage'] === 'closed_won' ? 'won' : 'open',
                'customer_id' => $customers[$i]->id,
                'assigned_to' => [$agent1->id, $agent2->id, $manager->id][rand(0, 2)],
                'created_by' => $admin->id,
                'expected_close_date' => now()->addDays(rand(15, 60)),
                'actual_close_date' => $data['stage'] === 'closed_won' ? now()->subDays(rand(1, 30)) : null,
            ]));
        }

        // Tasks
        $tasksData = [
            ['title' => 'Follow up with TCS team', 'type' => 'call', 'priority' => 'high', 'status' => 'pending'],
            ['title' => 'Send proposal to Infosys', 'type' => 'email', 'priority' => 'high', 'status' => 'in_progress'],
            ['title' => 'Demo for Wipro security team', 'type' => 'demo', 'priority' => 'medium', 'status' => 'pending'],
            ['title' => 'Contract review meeting', 'type' => 'meeting', 'priority' => 'urgent', 'status' => 'pending'],
            ['title' => 'Quarterly review call', 'type' => 'call', 'priority' => 'low', 'status' => 'completed'],
        ];

        foreach ($tasksData as $data) {
            Task::create(array_merge($data, [
                'description' => 'Task related to customer engagement',
                'assigned_to' => [$agent1->id, $agent2->id][rand(0, 1)],
                'created_by' => $admin->id,
                'due_date' => now()->addDays(rand(-2, 14)),
                'completed_at' => $data['status'] === 'completed' ? now()->subDays(1) : null,
            ]));
        }

        // Activities
        Activity::create(['type' => 'created', 'description' => 'System initialized with sample data', 'causer_id' => $admin->id]);
        Activity::create(['type' => 'created', 'description' => "Customer 'TCS' was created", 'subject_type' => Customer::class, 'subject_id' => $customers[0]->id, 'causer_id' => $admin->id]);
        Activity::create(['type' => 'created', 'description' => "Lead 'ERP Implementation Project' was created", 'causer_id' => $agent1->id]);

        // Notifications
        Notification::create(['user_id' => $admin->id, 'type' => 'info', 'title' => 'Welcome', 'message' => 'Welcome to Regional CRM! Your system is ready.']);
        Notification::create(['user_id' => $admin->id, 'type' => 'success', 'title' => 'Sample data', 'message' => 'Sample data has been loaded successfully.']);
        Notification::create(['user_id' => $manager->id, 'type' => 'info', 'title' => 'Tasks due', 'message' => 'You have 2 tasks due today.']);
        Notification::create(['user_id' => $support->id, 'type' => 'info', 'title' => 'Welcome', 'message' => 'Welcome! You can handle customer issues and create notes/tasks.']);
    }
}
