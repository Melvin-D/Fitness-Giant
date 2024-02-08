<?php
include 'view/header.php';
session_start();
?>

<header>
    <h1>Select an option or log-in</h1>
</header>

<main>
    <nav>
    <div class="dropdown">
        <button class="dropbtn">Log In</button>
        <div class="dropdown-content">
        <a href="main_menu_login/admin_login.php">Administrators</a>
        <a href="update_workout_session/trainer_login.php">Personal Trainers</a>
        <a href="client_login/login_page.php">Clients</a>
        </div>
    </div>

    <div class="exercise_link">
    <h2 class="exercise_link-text"><a href="franchise_locations.php">Locations</a></h2>
    </div>

    <!-- These are for future development and just a placeholder for potential ideas-->
    <h1>To be added in the future</h1>
    <div class="exercise_link">
    <h2  class="exercise_link-text"><a href="under_construction.php">Meal Plans</a></h2>
    </div>

    <div class="exercise_link">
    <h2 class="exercise_link-text"><a href="under_construction.php">Supplements</a></h2>
    </div>

    <div class="exercise_link">
    <h2 class="exercise_link-text"><a href="under_construction.php">Suggestions</a></h2>
    </div>

    <div class="exercise_link">
    <h2 class="exercise_link-text"><a href="under_construction.php">Inquire Today</a></h2>
    </div>

    <div class="exercise_link">
    <h2 class="exercise_link-text"><a href="under_construction.php">Create a plan</a></h2>
    </div>

</section>
<?php include 'view/footer.php'; ?>