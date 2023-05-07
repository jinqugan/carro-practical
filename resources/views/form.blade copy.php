<!DOCTYPE html>
<?php
// Output messages
$response = '';
// Check if the form was submitted
if (isset($_POST['rating'], $_POST['hear_about_us'], $_POST['contact_pref'], $_POST['email'], $_POST['comments'], $_POST['recommend'])) {
    // Process form data
    // Assign POST variables
    $rating = $_POST['rating'];
    $hear_about_us = $_POST['hear_about_us'];
    $contact_pref = implode(', ', $_POST['contact_pref']);
    $email = $_POST['email'];
    $comments = $_POST['comments'];
    $recommend = $_POST['recommend'];
    // Where to send the mail? It should be your email address
    $to = 'surveys@yourwebsite.com';
    // Mail from
    $from = 'noreply@yourwebsite.com';
    // Mail subject
    $subject = 'A user has submitted a survey';
    // Mail headers
    $headers = 'From: ' . $from . "\r\n" . 'Reply-To: ' . $from . "\r\n" . 'Return-Path: ' . $from . "\r\n" . 'X-Mailer: PHP/' . phpversion() . "\r\n" . 'MIME-Version: 1.0' . "\r\n" . 'Content-Type: text/html; charset=UTF-8' . "\r\n";
    // Capture the email template file as a string
    ob_start();
    include 'email-template.php';
    $email_template = ob_get_clean();
    // Try to send the mail
    if (mail($to, $subject, $email_template, $headers)) {
        // Success
        $response = '<h3>Thank You!</h3><p>With your help, we can improve our services for all our trusted members.</p>';
    } else {
        // Fail
        $response = '<h3>Error!</h3><p>Message could not be sent! Please check your mail server settings!</a>';
    }
}
?>

<html lang="en">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width,minimum-scale=1">
    <title>Survey Form</title>
    <link rel="stylesheet" href="https://use.fontawesome.com/releases/v5.7.1/css/all.css">
    {{-- <link rel="stylesheet" href="style.css"> --}}
    <!-- Scripts -->
    @vite(['resources/sass/app.scss', 'resources/js/app.js'])

    <link href="{{ asset('css/styles.css') }}" rel="stylesheet">

</head>

<body>
    <div style="height:35px;"></div>

    <form class="survey-form ">
        <!-- place code here -->
        <h1><i class="far fa-list-alt"></i>{{ $results['data']['survey']['title'] }}</h1>
        {{--
        <div id="inputContainer" class="step-content current">
            <div class="fields">
                <label for="email">Your Email</label>
                <div class="field">
                    <i class="fas fa-envelope"></i>
                    <input id="email" type="email" name="email" placeholder="Your Email" required>
                </div>
                <label for="comments">Additional Comments</label>
                <div class="field">
                    <textarea id="comments" name="comments" placeholder="Enter your comments ..."></textarea>
                </div>
            </div>
        </div> --}}



        {{-- </div> --}}

    </form>

    <div id="inputFields" class="step-content current">
        {{-- <form class="survey-form mt-4">
                <!-- place code here -->
                <div class="step-content current">
                    <div class="fields">
                        <div class="space-between">
                            <label for="email">Your Email</label>
                            <i class="fas fa-envelope" onclick="removeInput(event)"></i>
                        </div>
                        <div class="field">
                            <i class="fas fa-envelope"></i>
                            <input id="email" type="email" name="email" placeholder="Your Email" required>
                        </div>
                        <label for="comments">Additional Comments</label>
                        <div class="field">
                            <textarea id="comments" name="comments" placeholder="Enter your comments ..."></textarea>
                        </div>
                    </div>
                </div>
            </form> --}}
    </div>

    <form class="survey-form mt-4 mb-4">
        <div class="">
            <div class="fields">
                <div class="row">
                    <div class="col-6">
                        <div class="field error-msg">
                            {{-- <i class="fas fa-envelope"></i> --}}
                            <input id="dLabel" type="text" name="dLabel" class="inputselect"
                                placeholder="Untitiled Question" title="Please input a value" required>
                            <span class="tooltiptext">Please enter value.</span>
                        </div>
                    </div>
                    <div class="col-6">
                        <select name="options" id="inputOption">
                            <option value="text">Short answer</option>
                            <option value="number">Number</option>
                            <option value="date">Date</option>
                        </select>
                    </div>
                </div>

                <div class="fields buttons">
                    <a class="btn" onclick="addInput('text')">
                        <i class="fas fa-plus"></i>
                        <span>&nbsp;Add</span>
                    </a>
                </div>

                <div class="fields buttons">
                    <a class="btn" onclick="submit()">
                        <i class="fas fa-plus"></i>
                        <span>&nbsp;Submit</span>
                    </a>
                </div>
            </div>
    </form>


    {{-- <form class="survey-form mt-4 mb-4">
        <div id="inputContainer123" class="step-content current">
            <div class="fields">
                <div class="row">
                    <div class="col-6">
                        <div class="field">
                            <input id="dLabel" type="text" name="text" placeholder="Untitiled Question"
                                required>
                        </div>
                    </div>
                    <div class="col-6">
                        <select name="options" id="inputOption">
                            <option value="text">Short answer</option>
                            <option value="textarea">Paragraph</option>
                            <option value="date">Date</option>
                        </select>
                    </div>
                </div>

                <div class="buttons">
                    <a class="btn" onclick="addInput()">Add</a>
                </div>
            </div>
    </form> --}}

    {{-- </div> --}}
    <div style="height:15px;"></div>

    <script>
        function submit() {
            let params = [];
            const inputFields = document.getElementById("inputFields");
            const inputs = inputFields.getElementsByTagName("form");

            for (let i = 0; i < inputs.length; i++) {
                var answer = inputs[i].getElementsByTagName("input")[0];
                var question = inputs[i].querySelector("label[for=" + answer.type + "]");

                console.log(question);
                params.push({
                    'question': question.textContent,
                    'answer': answer.value,
                    'type': answer.type,
                });
            }

            console.log(params);
        }

        function text() {
            var html = '';
            var title = document.getElementById("dLabel").value;
            var option = document.getElementById("inputOption").value;

            html += '<form class="survey-form mt-4">';
            html += '   <div class="fields">';
            html += '       <div class="space-between">';
            html += '           <label for="' + option + '">' + title + '</label>';
            html += '           <i class="fas fa-trash" onclick="removeInput(event)"></i>';
            html += '       </div>';
            html += '       <div class="field">';
            html += '           <input id="" type="' + option + '" name="" placeholder="" required>';
            html += '       </div>';
            html += '   </div>';
            html += '</form>';
            // html += '<label for="comments">Additional Comments</label>';
            // html += '<div class="field">';
            // html += '<textarea id="comments" name="comments" placeholder="Enter your comments ..."></textarea>';
            // html += '</div>';


            return html;
        }

        function removeInput(event) {
            var inputWrapper = event.target.closest('form');
            inputWrapper.parentNode.removeChild(inputWrapper);
        }

        function addInput() {
            var option = document.getElementById("inputOption").value;
            var title = document.getElementById("dLabel").value;
            var labelElement = document.getElementById("dLabel");

            if (!document.getElementById("dLabel").checkValidity()) {
                labelElement.classList.add('error');
                labelElement.parentElement.classList.add('form-error');
                // alert("Please fill in untitiled question.");
                return false;
            }

            var newInput = document.createElement("input");
            newInput.type = "text";
            var container = document.getElementById("inputFields");

            container.insertAdjacentHTML('beforeend', text());
            labelElement.value = '';
            labelElement.classList.remove('error');
            labelElement.parentElement.classList.remove('form-error');
        }

        // const setStep = step => {
        //     document.querySelectorAll(".step-content").forEach(element => element.style.display = "none");
        //     document.querySelector("[data-step='" + step + "']").style.display = "block";
        //     document.querySelectorAll(".steps .step").forEach((element, index) => {
        //         index < step - 1 ? element.classList.add("complete") : element.classList.remove(
        //             "complete");
        //         index == step - 1 ? element.classList.add("current") : element.classList.remove(
        //             "current");
        //     });
        // };
        // document.querySelectorAll("[data-set-step]").forEach(element => {
        //     element.onclick = event => {
        //         event.preventDefault();
        //         setStep(parseInt(element.dataset.setStep));
        //     };
        // });
        <?php if (!empty($_POST)): ?>
        setStep(4);
        <?php endif; ?>
    </script>
</body>

</html>
