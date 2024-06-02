<?php include('includes/header.php') ?>

<div class="container-fluid px-4">
    <div class="card mt-4 shadow">
        <div class="card-header">
            <?php if (isset($_GET['id']) && isset($_GET['name'])) : ?>
                <h4 class="mb-0">Add Record
                    <a href="grades.php?id=<?= $_GET['id']; ?>&name=<?= urlencode($_GET['name']) ?>" class="btn btn-primary float-end">Back</a>
                </h4>
            <?php endif; ?>
        </div>
        <div class="card-body">
            <div id="alert-container"></div>
            <?php
            $parmValue = checkParamId('id');
            if (!is_numeric($parmValue)) {
                echo '<h5>' . $parmValue . '</h5>';
                return false;
            }
            $record = getById('class_record', $parmValue);
            if ($record['status'] == 200) {
            $class_id = $record['data']['class_id'];

            $tableRows = generateTable($class_id);
            $tableRowsSemester1 = $tableRows['semester1'];
            $tableRowsSemester2 = $tableRows['semester2'];
            ?>
            <form id="gradesForm">
                <div class="row">
                    <div class="col-md-12 mb-3">
                        <label for="">Student *</label>
                        <select name="student" class="form-control select2" style="width: 100%;" required>
                            <option value="" selected disabled>-- Select --</option>
                            <?php
                            $students = getAll('students');
                            if ($students && mysqli_num_rows($students) > 0) {
                                while ($student = mysqli_fetch_assoc($students)) {
                                    echo '<option value="' . $student['id'] . '">' . $student['name'] . '</option>';
                                }
                            } else {
                                echo '<option value="">No students available</option>';
                            }
                            ?>
                        </select>
                    </div>
                </div>
                <div class="row">
                    <div class="col-md-12">
                        <h5>First Semester</h5>
                        <table id="semester1-table" class="table table-bordered table-striped table-hover">
                            <thead>
                                <tr>
                                    <th width="70%">Subject</th>
                                    <th class="text-center" width="15%">Q1</th>
                                    <th class="text-center" width="15%">Q2</th>
                                    <th width="15%">Final</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php echo $tableRowsSemester1; ?>
                                <tr class="fw-bold">
                                    <td class="text-end" colspan="3">General Average for the Semester</td>
                                    <td id="semester1-general-average"></td>
                                </tr>

                            </tbody>
                        </table>

                        <h5>Second Semester</h5>
                        <table id="semester2-table" class="table table-bordered table-striped table-hover">
                            <thead>
                                <tr>
                                    <th width="70%">Subject</th>
                                    <th class="text-center" width="15%">Q3</th>
                                    <th class="text-center" width="15%">Q4</th>
                                    <th width="15%">Final</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php echo $tableRowsSemester2; ?>
                                <tr class="fw-bold">
                                    <td class="text-end" colspan="3">General Average for the Semester</td>
                                    <td id="semester2-general-average"></td>
                                </tr>

                            </tbody>
                        </table>
                    </div>

                    <div class="col-md-12 mb-3 text-end">
                        <button type="submit" name="saveGrade" class="btn btn-primary">Save</button>
                    </div>
                </div>

            </form>
            <?php
                } else {
                    echo '<h5>' . $record['message'] . '</h5>';
                }
                ?>
        </div>
    </div>
</div>

<?php include('includes/footer.php') ?>
<script>
    $(document).ready(function() {
        var urlParams = new URLSearchParams(window.location.search);
        var id = urlParams.get('id');

        function validateInputFields() {
            $('input[name^="quarter1_"], input[name^="quarter2_"]').each(function() {
                var value = parseInt($(this).val(), 10);
                if (isNaN(value) || value < 0 || value > 100) {
                    $(this).val(''); // Clear the input field if the value is not within the range
                }
            });
        }

        // Call the validateInputFields function on input change
        $('input[name^="quarter1_"], input[name^="quarter2_"]').on('input', function() {
            validateInputFields();
        });

        // Function to compute the final grade
        function computeFinalGrade(quarter1, quarter2) {
            var q1 = parseFloat(quarter1);
            var q2 = parseFloat(quarter2);
            if (!isNaN(q1) && !isNaN(q2)) {
                return ((q1 + q2) / 2).toFixed(2); // Compute the average
            }
            return '';
        }

        // Function to check if all input fields in a table have values
        function allInputFieldsFilled(tableId) {
            var allFilled = true;
            $('#' + tableId + ' tbody tr').each(function() {
                var quarter1 = $(this).find('input[name^="quarter1_"]').val();
                var quarter2 = $(this).find('input[name^="quarter2_"]').val();
                if (quarter1 === '' || quarter2 === '') {
                    allFilled = false;
                    return false; // Break the loop if any field is empty
                }
            });
            return allFilled;
        }

        // Function to compute the general average for the semester
        function computeGeneralAverage(tableId) {
            var total = 0;
            var count = 0;
            $('#' + tableId + ' tbody tr').each(function() {
                var quarter1 = $(this).find('input[name^="quarter1_"]').val();
                var quarter2 = $(this).find('input[name^="quarter2_"]').val();
                if (quarter1 !== '' && quarter2 !== '') {
                    var finalGrade = computeFinalGrade(quarter1, quarter2);
                    if (finalGrade !== '') {
                        total += parseFloat(finalGrade);
                        count++;
                    }
                }
            });
            if (count > 0) {
                return (total / count).toFixed(2);
            }
            return '';
        }

        // Function to update the "General Average for the Semester" cell text based on input completion
        function updateGeneralAverageCell(tableId, cellId) {
            var generalAverage = '';
            if (allInputFieldsFilled(tableId)) {
                generalAverage = computeGeneralAverage(tableId);
            }
            // Update the text content of the "General Average for the Semester" cell
            $('#' + cellId).text(generalAverage);
        }

        // Event handler for input changes in all quarter grade fields
        $('#semester1-table, #semester2-table').on('input', 'input[name^="quarter1_"], input[name^="quarter2_"], input[name^="quarter3_"], input[name^="quarter4_"]', function() {
            // Update the final grade dynamically
            var row = $(this).closest('tr');
            var quarter1 = row.find('input[name^="quarter1_"]').val();
            var quarter2 = row.find('input[name^="quarter2_"]').val();
            var quarter3 = row.find('input[name^="quarter3_"]').val();
            var quarter4 = row.find('input[name^="quarter4_"]').val();

            var finalGrade = '';
            if (quarter1 !== '' && quarter2 !== '') {
                finalGrade = computeFinalGrade(quarter1, quarter2);
            } else if (quarter3 !== '' && quarter4 !== '') {
                finalGrade = computeFinalGrade(quarter3, quarter4);
            }

            row.find('td').eq(3).text(finalGrade);

            // Update the "General Average for the Semester" cell text
            if ($(this).closest('table').attr('id') === 'semester1-table') {
                updateGeneralAverageCell('semester1-table', 'semester1-general-average');
            } else {
                updateGeneralAverageCell('semester2-table', 'semester2-general-average');
            }
        });

        $('#gradesForm').on('submit', function(event) {
    event.preventDefault(); // Prevents the default form submission behavior

    // Function to check if a row represents the "General Average" row
    function isGeneralAverageRow(row) {
        return row.find('td:first').text() === 'General Average for the Semester';
    }

    // Function to extract data from table rows
    function extractDataFromRows(tableId) {
        var semesterData = [];
        $('#' + tableId + ' tbody tr').each(function() {
            var row = $(this);
            if (!isGeneralAverageRow(row)) { // Exclude the "General Average" row
                var subjectId = row.find('input[name^="subject_id"]').val();
                var quarter1Grade = row.find('input[name^="quarter1_"]').val();
                var quarter2Grade = row.find('input[name^="quarter2_"]').val();

                var subjectData = {
                    subject_id: subjectId,
                    quarter_1_grade: quarter1Grade,
                    quarter_2_grade: quarter2Grade
                };

                semesterData.push(subjectData);
            }
        });
        return semesterData;
    }

    // Extract data from both semesters
    var semester1Data = extractDataFromRows('semester1-table');
    var semester2Data = extractDataFromRows('semester2-table');

    // Function to compute the final grade
    function computeFinalGrade(semesterData) {
        var total = 0;
        var count = 0;
        semesterData.forEach(function(subject) {
            if (subject.quarter_1_grade !== '' && subject.quarter_2_grade !== '') {
                var finalGrade = ((parseFloat(subject.quarter_1_grade) + parseFloat(subject.quarter_2_grade)) / 2).toFixed(2);
                subject.final_grade = finalGrade;
                total += parseFloat(finalGrade);
                count++;
            }
        });
        return count > 0 ? (total / count).toFixed(2) : '';
    }

    // Compute final grades and general averages
    var semester1FinalAverage = computeFinalGrade(semester1Data);
    var semester2FinalAverage = computeFinalGrade(semester2Data);

    // Construct the data object
    var formData = {
        recordId: id,
        studentId: $('[name="student"]').val(),
        semester1: semester1Data,
        semester2: semester2Data,
        semester1_final_average: semester1FinalAverage,
        semester2_final_average: semester2FinalAverage
    };

    var grades = JSON.stringify(formData);

    $.ajax({
        url: 'code.php',
        type: 'POST',
        data: {
            saveGrade: true,
            grades: grades,
        },
        dataType: "json",
        success: function(response) {
            if (response.success) {
                showAlert("success", response.message);
                // Reset final grades and general average
                $('td[id$="-general-average"]').text('');
                $('table[id$="-table"] tbody tr').each(function() {
                    $(this).find('td').eq(3).text('');
                });
                $("#gradesForm")[0].reset();
                $('select[name^="student"]').val("").trigger("change");
            } else {
                showAlert("warning", response.message);
            }
        },
    });
});


    });
</script>