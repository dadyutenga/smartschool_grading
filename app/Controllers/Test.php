<?php

namespace App\Controllers;

class Test extends \CodeIgniter\Controller
{
    public function index()
    {
        echo "<h1>CodeIgniter Test</h1>";
        
        // Test database connection
        try {
            $db = \Config\Database::connect();
            echo "<p style='color:green'>✓ Database connection successful!</p>";
            
            // List tables
            $tables = $db->listTables();
            echo "<p>Tables in database: " . implode(", ", $tables) . "</p>";
            
            // Test users table
            $query = $db->query("SELECT COUNT(*) as count FROM users");
            $result = $query->getRow();
            echo "<p>Number of users in database: " . $result->count . "</p>";
            
            // Test session
            $session = \Config\Services::session();
            $session->set('test', 'Session is working');
            echo "<p>Session test value: " . $session->get('test') . "</p>";
            
            // Show database config
            echo "<p>Database name: " . $db->getDatabase() . "</p>";
            
        } catch (\Exception $e) {
            echo "<p style='color:red'>✗ Error: " . $e->getMessage() . "</p>";
        }
    }
    
    public function users()
    {
        try {
            $db = \Config\Database::connect();
            $query = $db->query("SELECT id, username, role, is_active FROM users LIMIT 10");
            $users = $query->getResult();
            
            echo "<h1>Sample Users</h1>";
            echo "<table border='1' cellpadding='5'>";
            echo "<tr><th>ID</th><th>Username</th><th>Role</th><th>Active</th></tr>";
            
            foreach ($users as $user) {
                echo "<tr>";
                echo "<td>" . $user->id . "</td>";
                echo "<td>" . $user->username . "</td>";
                echo "<td>" . $user->role . "</td>";
                echo "<td>" . $user->is_active . "</td>";
                echo "</tr>";
            }
            
            echo "</table>";
            
        } catch (\Exception $e) {
            echo "<p style='color:red'>Error: " . $e->getMessage() . "</p>";
        }
    }
} 