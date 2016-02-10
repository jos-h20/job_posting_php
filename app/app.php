<?php
    require_once __DIR__."/../vendor/autoload.php";
    require_once __DIR__."/../src/JobOpening.php";
    require_once __DIR__."/../src/Contact.php";

    session_start();
    if (empty($_SESSION['available_jobs'])) {
        $_SESSION['available_jobs'] = array();
    }

    $app = new Silex\Application();

    $app->get("/", function() {

        $output = "";

        $all_jobs = JobOpening::getAll();

        if (!empty($all_jobs)) {

            $output .= "
                 <h1>Job Board</h1>
                 <p>Here are all your jobs:</p>";

            foreach ($all_jobs as $job) {
                $contacts = $job->getContact();
                $output .= "<p>" . $job->getTitle() . "</br>" . $job->getDescript() . "</br>" . $contacts->getName() . "</br>" . $contacts->getEmail() . "</br>" . $contacts->getPhoneNumba() . "</p>";
            }


        }

        $output .= "
            <form action='/view_job' method='post'>
                <div class='form-group'>
                  <label for='title'>Enter the title:</label>
                  <input id='title' name='title' class='form-control' type='text'>
                </div>
                <div class='form-group'>
                  <label for='description'>Enter the description:</label>
                  <input id='description' name='description' class='form-control' type='text'>
                </div>
                <div class='form-group'>
                  <label for='name'>Enter the name:</label>
                  <input id='name' name='name' class='form-control' type='text'>
                </div>
                <div class='form-group'>
                  <label for='email'>Enter the email:</label>
                  <input id='email' name='email' class='form-control' type='text'>
                </div>
                <div class='form-group'>
                  <label for='phone'>Enter the phone numba:</label>
                  <input id='phone' name='phone' class='form-control' type='number'>
                </div>

                <button type='submit' class='btn-success'>Create</button>
            </form>
        ";

        $output .= "
            <form action='/delete_jobs' method='post'>
                <button type='submit'>Clear</button>
            </form>
        ";


        return $output;
    });
    //
    //     return "
    //     <!DOCTYPE html>
    //     <html>
    //     <head>
    //         <link rel='stylesheet' href='https://maxcdn.bootstrapcdn.com/bootstrap/3.3.6/css/bootstrap.min.css'>
    //         <title>Make a rectangle!</title>
    //     </head>
    //     <body>
    //         <div class='container'>
    //             <h1>Joberator</h1>
    //             <p>Type in a sweet job that pays super well.</p>
    //             <form action='/view_job'>
    //                 <div class='form-group'>
    //                   <label for='title'>Enter the title:</label>
    //                   <input id='title' name='title' class='form-control' type='text'>
    //                 </div>
    //                 <div class='form-group'>
    //                   <label for='description'>Enter the description:</label>
    //                   <input id='description' name='description' class='form-control' type='text'>
    //                 </div>
    //                 <div class='form-group'>
    //                   <label for='name'>Enter the name:</label>
    //                   <input id='name' name='name' class='form-control' type='text'>
    //                 </div>
    //                 <div class='form-group'>
    //                   <label for='email'>Enter the email:</label>
    //                   <input id='email' name='email' class='form-control' type='text'>
    //                 </div>
    //                 <div class='form-group'>
    //                   <label for='phone'>Enter the phone numba:</label>
    //                   <input id='phone' name='phone' class='form-control' type='number'>
    //                 </div>
    //                 <button type='submit' class='btn-success'>Create</button>
    //             </form>
    //         </div>
    //     </body>
    //     </html>
    //     ";
    // });



    $app->post("/view_job", function() {

    $output = "";
    $new_contact = new Contact($_POST["name"], $_POST["email"], $_POST["phone"]);
    $new_job = new JobOpening($_POST["title"], $_POST["description"], $new_contact);
    $new_job->save();

    $title = $new_job->getTitle();
    $description = $new_job->getDescript();
    $job_contact = $new_job->getContact();

    $name = $job_contact->getName();
    $email = $job_contact->getEmail();
    $number = $job_contact->getPhoneNumba();

//     $available_jobs = array();
//
//     array_push($available_jobs, $new_job);
//
// var_dump($available_jobs);
        return "
        <h1>Here is your new job listing:</h1>
        <h3>$title</h3>
        <h4>$description</h4>
        <ul>
            <li>$name</li>
            <li>$email</li>
            <li>$number</li>
        </ul>
      
      ";

    });


    $app->post("/delete_jobs", function() {

        JobOpening::deleteAll();

        return "
            <h1>List cleared!</h1>
            <p><a href='/'>Home</a></p>
        ";
    });


  return $app;


 ?>
