<?php
    # application period ended
    if (isset($_POST['submit'])) {
        # get the youngest applicant and remove them from applicants
        function getYoungestApplicant(& $applicants) {
            # get youngest applicant
            $max_indx = 0;
            $max_dob = $applicants[0];

            for ($i = 1; $i < count($applicants); $i++) {
                if ($applicants[$i]['DOB'] > $max_dob) {
                    $max_indx = $i;
                    $max_dob = $applicants[$i]['DOB'];
                }
            }

            # save youngest applicant
            $youngest_applicant = $applicants[$max_indx];

            # remove youngest applicant
            unset($applicants[$max_indx]);

            # reindex b/c this language is stupid
            $applicants = array_values($applicants);

            return $youngest_applicant;
        }

        # append applicant onto $xml, which should be a string
        function append_applicant(& $xml, $applicant) {
            $xml .= "\t<winner>\n";
            $xml .= "\t\t<id>" . $applicant['ID'] . "</id>\n";
            $xml .= "\t\t<status>" . $applicant['STATUS'] . "</status>\n";
            $xml .= "\t\t<cgpa>" . $applicant['CUM_GPA'] . "</cgpa>\n";
            $xml .= "\t\t<gender>" . $applicant['GENDER'] . "</gender>\n";
            $xml .= "\t\t<fname>" . $applicant['FNAME'] . "</fname>\n";
            $xml .= "\t\t<lname>" . $applicant['LNAME'] . "</lname>\n";
            $xml .= "\t\t<phoneNum>" . $applicant['PHONE_NUM'] . "</phoneNum>\n";
            $xml .= "\t\t<email>" . $applicant['EMAIL'] . "</email>\n";
            $xml .= "\t\t<dob>" . $applicant['DOB'] . "</dob>\n";
            $xml .= "\t\t<creditHours>" . $applicant['CREDIT_HOURS'] . "</creditHours>\n";
            $xml .= "\t</winner>\n";
        }

        # generate xml file
        function generate_xml($applicants, $oneWinner = true) {
            # there's a winner
            if ($oneWinner) {
                # create xml file
                $xml = "<?xml version=\"1.0\" encoding=\"UTF-8\"?>\n";
                $xml .= "<winners>\n";
                append_applicant($xml, $applicants);
                $xml .= "</winners>\n";

                # create file handler
                $xmlFile = fopen('../data/winners.xml', 'w');

                # write to file
                fwrite($xmlFile, $xml);

                # close file handler
                fclose($xmlFile);
            }

            # no winner, must do interviews
            else {
                # create xml file
                $xml = "<?xml version=\"1.0\" encoding=\"UTF-8\"?>\n";
                $xml .= "<winners>\n";
                append_applicant($xml, $applicants[0]);
                append_applicant($xml, $applicants[1]);
                $xml .= "</winners>\n";

                # create file handler
                $xmlFile = fopen('../data/winners.xml', 'w');

                # write to file
                fwrite($xmlFile, $xml);

                # close file handler
                fclose($xmlFile);
            }
        }

        # processes the winner
        function process_winner($winningApplicant, $applicants) {
            # get database connection
            include('../database.php');

            # get full name
            $full_name = $winningApplicant['FNAME'] . ' ' . $winningApplicant['LNAME'];

            # generate xml for winner
            generate_xml($winningApplicant);

            # get tuition paid
            $tuition = $conn->query('SELECT TUITION FROM STUDENTS WHERE ID=' . $winningApplicant['ID'], PDO::FETCH_OBJ);
            $tuition = $tuition->fetch();
            $tuition = $tuition->TUITION;

            # insert into awarded table
            $id = $winningApplicant['ID'];
            $insert = "INSERT INTO AWARDED (ID, AMOUNT_AWARDED, FULL_NAME)";
            $insert .= "VALUES ($id, '$tuition', '$full_name')";
            $conn->query($insert);

            # email winner
            $winner_email_body = "";
            $winner_email_body .= "Hi $full_name,\n\n";
            $winner_email_body .= "You won the B. S. T. Smart Scholarship! Congratulations! ";
            $winner_email_body .= "You will be reimbursed for tuition this semester, a total of ";
            $winner_email_body .= "$$tuition! Amazing!!!\n\n";
            $winner_email_body .= "Have an amazing rest of your day!!!!";

            # email winner
            if (!mail($winningApplicant['EMAIL'], 'You Won the B. S. T. Smart Scholarship!', $winner_email_body)) {
                echo 'Email to winner didn\'t send :(';
                exit();
            }

            # email for accounting department
            $accounting_email = "";
            $accounting_email .= "Hi Emma, Head of the Accounting Department,\n\n";
            $accounting_email .= "$full_name won the B. S. T. Smart Scholarship this semester. ";
            $accounting_email .= "Please reimburse him/her $$tuition for this semester.\n\n";
            $accounting_email .= "Thanks.\n\n";
            $accounting_email .= "Regards,\n\n\n";
            $accounting_email .= "Committe for B. S. T. Smart Scholarship";

            # email account office
            if (!mail($winningApplicant['EMAIL'], 'Reimbursement for Student', $accounting_email)) {
                echo 'Account Email didnt send :(';
                exit();
            }

            # email other eligible applicants
            foreach ($applicants as $applicant) {
                # if applicant is not winner
                if ($winningApplicant['ID'] != $applicant['ID']) {
                    # email for non-winning eligible applicants
                    $fullname = $applicant['FNAME'] . ' ' . $applicant['LNAME'];
                    $other_applicant_email = "";
                    $other_applicant_email .= "Hi $fullname,\n\n";
                    $other_applicant_email .= "You didn't win the B. S. T. Smart Scholarship.\n\n";
                    $other_applicant_email .= "Try harder next time!";
                    
                    # send email to eligible applicant
                    if (!mail($applicant['EMAIL'], "So Sorry, $fullname", $other_applicant_email)) {
                        echo 'Email to other eligible applicant did not send :(';
                        exit();
                    }
                }
            }

            # remove all records in applicants table
            $conn->query('DELETE FROM applicants');

            # go to results page
            header('Location: results.php');
            exit();
        }

        # get database connection
        include('../database.php');

        # get applicants table
        $applicants_sql = 'SELECT A.ID, A.FNAME, A.LNAME, A.CUM_GPA, SEM_GPA, A.STATUS, A.GENDER, A.EMAIL, ';
        $applicants_sql .= 'A.PHONE_NUM, A.DOB, A.CREDIT_HOURS ';
        $applicants_sql .= 'FROM APPLICANTS A, STUDENTS S ';
        $applicants_sql .= 'WHERE A.ID = S.ID AND ISELIGIBLE=\'Y\'';
        $query = $conn->query($applicants_sql);
        $applicants = $query->fetchall();
        $curr_applicant_pool = array_merge([], $applicants);
        $next_applicant_pool = [];
        
        # get maximum CGPA
        $max_cgpa = '0.00';
        foreach ($curr_applicant_pool as $applicant) {
            if (floatval($applicant['CUM_GPA']) > $max_cgpa) {
                $max_cgpa = $applicant['CUM_GPA'];
            }
        }

        # get applicants with max cgpa
        foreach ($curr_applicant_pool as $applicant) {
            if ($applicant['CUM_GPA'] === $max_cgpa) {
                array_push($next_applicant_pool, $applicant);
            }
        }

        # if there's one person with the highest cumulative gpa
        if (count($next_applicant_pool) == 1) {
            process_winner($next_applicant_pool[0], $applicants);
        }

        # consider students tied for highest CGPA
        $curr_applicant_pool = $next_applicant_pool;
        $next_applicant_pool = [];

        # consider semester GPA
        $max_sem_gpa = '0.00';
        foreach($curr_applicant_pool as $applicant) {
            if ($applicant['SEM_GPA'] > $max_sem_gpa) {
                $max_sem_gpa = $applicant['SEM_GPA'];
            }
        }

        # get people with highest semester GPA
        foreach ($curr_applicant_pool as $applicant) {
            if ($applicant['SEM_GPA'] == $max_sem_gpa) {
                array_push($next_applicant_pool, $applicant);
            }
        }

        # one person with highest semester gpa
        if (count($next_applicant_pool) == 1) {
            process_winner($next_applicant_pool[0], $applicants);
        }

        # consider juniors
        $curr_applicant_pool = $next_applicant_pool;
        $next_applicant_pool = [];

        # find juniors
        foreach ($curr_applicant_pool as $applicant) {
            if ($applicant['STATUS'] == 'JUNIOR') {
                array_push($next_applicant_pool, $applicant);
            }
        }

        # one junior
        if (count($next_applicant_pool) == 1) {
            process_winner($next_applicant_pool[0], $applicants);
        }

        # more juniors
        else if (count($next_applicant_pool) > 1) {
            $curr_applicant_pool = $next_applicant_pool;
            $next_applicant_pool = [];
        }

        # find all females in remaining applicants
        foreach ($curr_applicant_pool as $applicant) {
            if ($applicant['GENDER'] == 'F') {
                array_push($next_applicant_pool, $applicant);
            }
        }

        # one female
        if (count($next_applicant_pool) == 1) {
            process_winner($next_applicant_pool[0], $applicants);
        }

        # more females
        else if (count($next_applicant_pool) > 1) {
            $curr_applicant_pool = $next_applicant_pool;
            $next_applicant_pool = [];
        }

        # get two youngest applicants
        $youngest_applicants[] = getYoungestApplicant($curr_applicant_pool);
        $youngest_applicants[] = getYoungestApplicant($curr_applicant_pool);

        # generate xml for both applicants
        generate_xml($youngest_applicants, false);

        # email other eligible applicants
        foreach ($applicants as $applicant) {
            # if applicant is not a winner
            if ($applicant['ID'] != $youngest_applicants[0]['ID'] &&
                $applicant['ID'] != $youngest_applicants[1]['ID']) {

                # email for non-winning eligible applicants
                $fullname = $applicant['FNAME'] . ' ' . $applicant['LNAME'];
                $other_applicant_email = "";
                $other_applicant_email .= "Hi $fullname,\n\n";
                $other_applicant_email .= "You didn't win the B. S. T. Smart Scholarship.\n\n";
                $other_applicant_email .= "Try harder next time!";
                
                # send email to eligible applicant
                if (!mail($applicant['EMAIL'], "So Sorry, $fullname", $other_applicant_email)) {
                    echo 'Email to other eligible applicant did not send :(';
                    exit();
                }
            }
        }

        # empty applicants table
        $conn->query('DELETE FROM APPLICANTS');

        # go to results page
        header('Location: results.php');
        exit();
    }

    # otherwise
    else {
        echo '<h2>What the hell are you doing? No.</h2>';
        exit();
    }
?>