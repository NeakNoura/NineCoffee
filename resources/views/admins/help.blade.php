@extends('layouts.app')
@section('content')
<div class="row">
    <div class="col-md-10 offset-md-1">
        <section class="help-section card p-4">
            <h2 class="text-center mb-4">Help Center</h2>
            <p>Welcome to the Help Center! Below is a detailed guide on how to use your Coffee Shop Admin Dashboard effectively.</p>

            <ul>
                <li><strong>Dashboard:</strong> 
                    View real-time analytics including:
                    <ul>
                        <li><strong>Daily Views:</strong> Number of people visiting your coffee shop website each day.</li>
                        <li><strong>Sales:</strong> Track the total number of completed transactions.</li>
                        <li><strong>Comments:</strong> Customer feedback and product-related messages.</li>
                        <li><strong>Earnings:</strong> Total revenue generated from all orders.</li>
                    </ul>
                </li>
                <li><strong>Customers:</strong> 
                    Access a list of registered or purchasing customers. You can:
                    <ul>
                        <li>View customer details (name, country, order history).</li>
                        <li>Search and filter by customer name or location.</li>
                        <li>Delete or update customer information.</li>
                    </ul>
                </li>
                <li><strong>Orders:</strong> 
                    Manage all customer orders. You can:
                    <ul>
                        <li>View order name, price, payment status, and delivery status.</li>
                        <li>Update the status (Pending, Delivered, In Progress, Return).</li>
                        <li>Mark payments as "Paid" or "Due".</li>
                    </ul>
                </li>
                <li><strong>Messages:</strong> 
                    View messages from customers regarding orders or feedback. Make sure to:
                    <ul>
                        <li>Respond to questions or concerns promptly.</li>
                        <li>Use this to improve customer satisfaction and resolve issues.</li>
                    </ul>
                </li>
                <li><strong>Settings:</strong> 
                    Customize your admin profile. This includes:
                    <ul>
                        <li>Updating your name, profile picture, and contact info.</li>
                        <li>Managing system preferences (like language or theme).</li>
                    </ul>
                </li>
                <li><strong>Password:</strong> 
                    Secure your account by updating your password. 
                    <ul>
                        <li>Make sure it is strong (at least 8 characters, includes symbols and numbers).</li>
                        <li>Use this section if you feel your account security is compromised.</li>
                    </ul>
                </li>
                <li><strong>Sign Out:</strong> 
                    Safely log out of the admin panel. This ensures:
                    <ul>
                        <li>No unauthorized access after you leave the page.</li>
                        <li>Session ends properly to protect your admin data.</li>
                    </ul>
                </li>
            </ul>
            <p>If you need more assistance, please contact support at <a href="mailto:neaknoura@coffeeshop.com">support@coffeeshop.com</a>.</p>
        </section>
        
    </div>
</div>
@endsection
