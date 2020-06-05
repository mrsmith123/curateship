<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Exception;
use Illuminate\Support\Facades\Artisan;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Schema;
use Modules\Admin\Entities\Admin\Admin;

class InstallationController extends Controller
{
    /**
     * Show the admin account creation form.
     *
     * @return \Illuminate\Http\Response
     */
    public function showAdminForm()
    {
        return view('vendor.installer.admin');
    }

    /**
     * Skip the admin account creation step.
     *
     * @return \Illuminate\Http\RedirectResponse
     */
    public function skipAdminCreation()
    {
        $this->saveAdminInstalledLogFile('Admin Account Creation skipped on ' . now());

        $message = "<strong>Installation succeeded.</strong>";
        $message .= "<p>Admin account creation aborted.</p>";

        return redirect('/')->with([
            'message' => $message
        ]);
    }

    /**
     * Save the admin account to the database.
     *
     * @param \Illuminate\Http\Request
     * 
     * @return \Illuminate\Http\RedirectResponse
     */
    public function storeAdmin(Request $request)
    {
        $request->validate([
            'name' => 'required|string|min:4|max:255',
            'email' => 'required|email|unique:admins',
            'password' => 'required|string|min:6|max:30|confirmed'
        ]);

        $adminsTable = (new Admin)->getTable();

        # If the admins or the migrations table does not exist
        if (!Schema::hasTable('migrations') || !Schema::hasTable($adminsTable)) {
            try {
                # Try to migrate
                Artisan::call('migrate');
            } catch (Exception $e) {
                # Redirect back with an error if an exception is thrown
                return back()->withErrors([
                    'table' => [
                        "Database table [{$adminsTable}] does not exist"
                    ]
                ]);
            }
        }

        # Create a new Admin model instance
        $admin = new Admin;
        
        # Save the Admin attributes to the model
        $admin->name = $request->name;
        $admin->email = $request->email;
        $admin->password = Hash::make($request->password);

        # Save the Admin's account to the database
        $admin->save();

        # The message that we will display to the user
        # after redirecting them to the welcome route
        $message = "<strong>Installation succeeded.</strong>";
        $message = "<p>Admin account has been successfully created.</p>";
        $message .= "Click <a href='" . route('admins.login') . "'>here</a> to login.";

        $this->saveAdminInstalledLogFile(sprintf(
            'Admin account created on %s with Name: %s and Email: %s',
            now(),
            $admin->name,
            $admin->password
        ));
        
        # Redirect the user to the welcome route
        return redirect('/')->with(
            'message',
            $message
        );
    }

    /**
     * Save the admin_installed log file under
     * the storage folder.
     * 
     * This file will later on allow us to determine
     * whether the "Admin Account Creation" step
     * has been passed.
     * 
     * @param string $message
     *
     * @return void
     */
    protected function saveAdminInstalledLogFile(string $message)
    {
        $adminCreatedLogFile = storage_path('admin_installed');
        
        file_put_contents($adminCreatedLogFile, $message.PHP_EOL, FILE_APPEND | LOCK_EX);
    }
}