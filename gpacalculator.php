<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>GPA Calculator</title>
</head>

<body>

    <script>
        function addCourse() {
            var courseNum = document.getElementsByClassName('courses').length + 1;
            var courseList = document.getElementById('course_list');

            var courseNew = document.createElement('div');
            courseNew.setAttribute('class', 'courses');

            var courseNameInput = document.createElement('input');
            courseNameInput.setAttribute('type', 'text');
            courseNameInput.setAttribute('name', 'course_name[]');
            courseNameInput.setAttribute('class', 'course-name');
            courseNameInput.setAttribute('required', 'required');

            var creditHoursInput = document.createElement('input');
            creditHoursInput.setAttribute('type', 'text');
            creditHoursInput.setAttribute('name', 'course_hours[]');
            creditHoursInput.setAttribute('class', 'course-hours');
            creditHoursInput.setAttribute('required', 'required');

            var gradeInput = document.createElement('input');
            gradeInput.setAttribute('type', 'text');
            gradeInput.setAttribute('name', 'course_grades[]');
            gradeInput.setAttribute('class', 'course-grades');
            gradeInput.setAttribute('required', 'required');

            courseNew.append(`Class ${courseNum}: `, courseNameInput);
            courseNew.append('Credit Hours: ', creditHoursInput);
            courseNew.append('Grade: ', gradeInput);

            courseList.appendChild(courseNew);
        }

        function clearCalculator() {

        }
    </script>

    <h1>GPA Calculator</h1>
    <p>Add your courses and grades to calculate your semester GPA.</p>

    <form method="post" id="course-form">
        <input type="button" value="Add Course" onclick="addCourse()">
        <input type="submit" value="Submit">
        <button type="submit" value = "Clear" onclick="clearCalculator()">Clear</button>

        <div id="course_list"></div>
    </form>

    <?php
    if ($_SERVER["REQUEST_METHOD"] == "POST") {
        $course_names = $_POST['course_name'];
        $credit_hours = $_POST['course_hours'];
        $course_grades = $_POST['course_grades'];

        $gpa = calculateGPA($credit_hours, $course_grades);

        echo '<p> Semester GPA:</p>' . $gpa;

    }

    function calculateGPA($course_hours, $course_grades)
    {
        $grade_values = array(
            'A' => 4.0,
            'B' => 3.0,
            'C' => 2.0,
            'D' => 1.0,
            'F' => 0.0,

        );

        $grade_points = 0;
        $credit_hours = 0;

        for ($i = 0; $i < count($course_hours); $i++) {
            $grade = strtoupper($course_grades[$i]);
            if (isset($grade_values[$grade])) {
                $grade_points += $course_hours[$i] * $grade_values[$grade];
                $credit_hours += $course_hours[$i];
            } else {
                $grade_points += 0;
                $credit_hours += 0;
            }
        }

        if ($credit_hours > 0) {
            $gpa = $grade_points / $credit_hours;
            return number_format($gpa, 2, '.', '');
        } else {
            return '0.0';
        }
    }

    ?>

</body>

</html>