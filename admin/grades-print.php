<?php

require_once "assets/TCPDF-main/tcpdf.php";
include "../config/dbcon.php";

$pdf = new TCPDF(
    PDF_PAGE_ORIENTATION,
    PDF_UNIT,
    PDF_PAGE_FORMAT,
    true,
    "UTF-8",
    false
);

// remove default header/footer
$pdf->setPrintHeader(false);
$pdf->setPrintFooter(false);

// set image scale factor
$pdf->setImageScale(PDF_IMAGE_SCALE_RATIO);
// ---------------------------------------------------------
if(isset($_GET["id"]) && !empty($_GET["id"])) {
$grade_id = $_GET["id"];

$query = "SELECT s.name, s.age, s.gender, s.lrn, c.name AS section, c.academic_year, c.subjects, g.grades, g.gen_avg_first,  g.gen_avg_second
FROM students s
INNER JOIN grades g ON s.id = g.student_id
INNER JOIN class_record cr ON g.record_id = cr.id
INNER JOIN classes c ON cr.class_id = c.id
WHERE g.id = $grade_id";

$result = mysqli_query($conn, $query);

if(mysqli_num_rows($result) == 0) {
   die("Error: Grade ID not found or invalid.");
}

$row = mysqli_fetch_assoc($result);
$subjects = json_decode($row["subjects"], true);
$gradesData = json_decode($row["grades"], true);

$semesters = [
    1 => ["core" => [], "applied" => []],
    2 => ["core" => [], "applied" => []],
];

foreach ($subjects as $semester) {
    $sem = $semester["semester"];
    foreach ($semester["subjects"] as $subject) {
        $subjectId = $subject["subject_id"];
        $query = "SELECT name, subject_type FROM subjects WHERE id = $subjectId";
        $subjectResult = mysqli_query($conn, $query);

        if ($subjectResult && mysqli_num_rows($subjectResult) > 0) {
            $subjectData = mysqli_fetch_assoc($subjectResult);
            $subjectName = $subjectData["name"];
            $subjectType = $subjectData["subject_type"];

            if ($subjectType == 1) {
                $subjectGrades = isset($gradesData["semester$sem"])
                    ? $gradesData["semester$sem"]
                    : [];
                $gradeInfo = isset($subjectGrades[$subjectId])
                    ? $subjectGrades[$subjectId]
                    : null;
                $quarter1Grade = $gradeInfo["quarter_1_grade"] ?? "";
                $quarter2Grade = $gradeInfo["quarter_2_grade"] ?? "";
                $finalGrade = $gradeInfo["final_grade"] ?? "";

                $semesters[$sem]["core"][] = [
                    "subject_id" => $subjectId,
                    "subject_name" => $subjectName,
                    "quarter_1_grade" => $quarter1Grade,
                    "quarter_2_grade" => $quarter2Grade,
                    "final_grade" => $finalGrade,
                ];
            } elseif ($subjectType == 2) {
                $subjectGrades = isset($gradesData["semester$sem"])
                    ? $gradesData["semester$sem"]
                    : [];
                $gradeInfo = isset($subjectGrades[$subjectId])
                    ? $subjectGrades[$subjectId]
                    : null;
                $quarter1Grade = $gradeInfo["quarter_1_grade"] ?? "";
                $quarter2Grade = $gradeInfo["quarter_2_grade"] ?? "";
                $finalGrade = $gradeInfo["final_grade"] ?? "";

                $semesters[$sem]["applied"][] = [
                    "subject_id" => $subjectId,
                    "subject_name" => $subjectName,
                    "quarter_1_grade" => $quarter1Grade,
                    "quarter_2_grade" => $quarter2Grade,
                    "final_grade" => $finalGrade,
                ];
            }
        }
    }
}

function calculateAge($birthDate)
{
    $birthDate = new DateTime($birthDate);
    $currentDate = new DateTime();
    $age = $currentDate->diff($birthDate);
    return $age->y;
}
// ---------------------------------------------------------

$pdf->AddPage("L", "A4");
$pdf->SetFont("helvetica", "", 9);

$html =
    '
<table border="0">
   <tr>
      <td>
         <h3 align="center">REPORT ON ATTENDANCE</h3>
         <table cellspacing="0" cellpadding="2" border="1" align="left" style="float:right;width:450px;">
                     <tr align="center" style="font-weight: bold;">
                     <td></td>
                     <td>Jun</td>
                     <td>Jul</td>
                     <td>Aug</td>
                     <td>Sept</td>
                     <td>Oct</td>
                     <td>Nov</td>
                     <td>Dec</td>
                     <td>Jan</td>
                     <td>Feb</td>
                     <td>Mar</td>
                     <td>Total</td>
                  </tr>
                  <tr>
                     <td>No. of school days</td>
                     <td></td>
                     <td></td>
                     <td></td>
                     <td></td>
                     <td></td>
                     <td></td>
                     <td></td>
                     <td></td>
                     <td></td>
                     <td></td>
                     <td></td>
                  </tr>
                  <tr>
                     <td>No. of days present</td>
                     <td></td>
                     <td></td>
                     <td></td>
                     <td></td>
                     <td></td>
                     <td></td>
                     <td></td>
                     <td></td>
                     <td></td>
                     <td></td>
                     <td></td>
                  </tr>
                  <tr>
                     <td>No. of days absent</td>
                     <td></td>
                     <td></td>
                     <td></td>
                     <td></td>
                     <td></td>
                     <td></td>
                     <td></td>
                     <td></td>
                     <td></td>
                     <td></td>
                     <td></td>
                  </tr>
                  </table>
                  <div>&nbsp;<br><br><br></div>
                  <table cellspacing="0" cellpadding="2" border="0" style="float:right;width:400px;">
                  <tr>
                        <td colspan="2" align="center"><h3>PARENT/GUARDIAN\'S SIGNATURE</h3></td>
                  </tr>
                  <tr>
                        <td colspan="2"><small>First Semester</small></td>
                  </tr>
                  <tr>
                        <td width="20%">1<sup>st</sup> Quarter</td>
                        <td>_______________________________</td>
                  </tr>
                  <tr>
                        <td width="20%">2<sup>nd</sup> Quarter</td>
                        <td>_______________________________</td>
                  </tr>
                  <tr>
                        <td colspan="2"><small>Second Semester</small></td>
                  </tr>
                  <tr>
                        <td width="20%">3<sup>rd</sup> Quarter</td>
                        <td>_______________________________</td>
                  </tr>
                  <tr>
                        <td width="20%">4<sup>th</sup> Quarter</td>
                        <td>_______________________________</td>
                  </tr>
               </table>
               
         </td>
         <td>
         <div>DepEd FORM 138</div>
         <table border="0" style="float:right;width:450px;">
         <tr>
               <td width="20%">
                  <img src="https://logowik.com/content/uploads/images/upd-university-of-the-philippines-diliman8602.jpg" alt="School Logo" style="height: 100px;">
               </td>
               <td width="80%" style="text-align: center;">
                     Republic of the Philippines<br>
                     Department of Education<br>
                     Region XVIII, Negros Island Region
                     <h2>SCHOOL DIVISION OF NEGROS ORIENTAL</h2>
               </td>
         </tr>
      </table><br>
  <div>
  Name: ' .
    $row["name"] .
    '<br>
  LRN: ' .
    $row["lrn"] .
    '<br>
  Level/Section: ' .
    $row["section"] .
    '<br>
  School Year: ' .
    $row["academic_year"] .
    '<br>
      Track Stand:  STEM<br><br>
      Dear Parent:
      <p>  This report card shows the ability and progress your child has made in the different learning areas as well as his/her core values.</p>
      <p>  The school welcomes you should you desire to know more about your child\'s progress.</p>
      <table>
          <tr>
              <td colspan="2"align="right">_______________</td>
          </tr>
          <tr>
              <td colspan="2" align="right">Adviser</td>
          </tr>
          <tr>
              <td>_______________</td>
          </tr>
          <tr>
              <td>Principal</td>
          </tr>
      </table>

      <h3 align="center">Certificate of Transfer</h3>
      <p>Admitted to Grade: ______________________________________   Section: _________________</p>
      <p>Eligibility for Admission to Grade: ___________________________________________________</p>
      <p>Approved:</p>
      
      <table align="center">
          <tr>
              <td>_________________</td>
              <td>_________________</td>
          </tr>
          <tr>
              <td>Principal</td>
              <td>Adviser</td>
          </tr>
      </table>
      <br>
      <h3 align="center">Cancellation of Eligibility to Transfer</h3>
      <table cellpadding="3">
          <tr>
              <td width="50%">Admitted in: __________________________</td>
              <td>Date: ________</td>
          </tr>
          <tr>
              <td colspan="2" align="right">_________________</td>
          </tr>
          <tr>
              <td colspan="2" align="right">Principal</td>
          </tr>
      </table>
  </div>
      </td>
   </tr>
</table>
';
$pdf->writeHTML($html, true, false, false, false, "");

// -----------------------------------------------------------------------------
$pdf->AddPage("L", "A4");
$pdf->SetFont("helvetica", "", 9);

$html = '
<table border="0">
   <tr>
      <td>
         <h4 align="center">REPORT ON LEARNING PROGRESS AND ACHIEVEMENT</h4>
         <div>First Semester</div>';

$html .= '
        <table cellspacing="0" cellpadding="2" border="1" style="float:right;width:400px;">
            <tr align="center" style="font-weight: bold;">
               <td rowspan="2" width="320px;">&nbsp;<br>Subjects<br></td>
               <td colspan="2" width="70px;">Quarter</td>
               <td rowspan="2" width="80px;">Semester<br> Final Grades</td>
            </tr>
            <tr align="center" style="font-weight: bold;">
               <td>1</td>
               <td>2</td>
            </tr>
            <tr>
               <td colspan="4"><b>Core Subjects</b></td>
            </tr>';

foreach ($semesters[1]["core"] as $subject) {
    $subjectId = array_search(
        $subject["subject_id"],
        array_column($gradesData["semester1"], "subject_id")
    );
    $quarter1Grade =
        $gradesData["semester1"][$subjectId]["quarter_1_grade"] ?? "";
    $quarter2Grade =
        $gradesData["semester1"][$subjectId]["quarter_2_grade"] ?? "";
    $finalGrade = $gradesData["semester1"][$subjectId]["final_grade"] ?? "";

    $html .=
        '
                       <tr>
                           <td>' .
        $subject["subject_name"] .
        '</td>
                           <td align="center">' .
        $quarter1Grade .
        '</td>
                           <td align="center">' .
        $quarter2Grade .
        '</td>
                           <td align="center">' .
        $finalGrade .
        '</td>
                       </tr>';
}

$html .= '
            <tr>
               <td colspan="4"><b>Applied Subjects</b></td>
            </tr>';
foreach ($semesters[1]["applied"] as $subject) {
    $subjectId = array_search(
        $subject["subject_id"],
        array_column($gradesData["semester1"], "subject_id")
    );
    $quarter1Grade =
        $gradesData["semester1"][$subjectId]["quarter_1_grade"] ?? "";
    $quarter2Grade =
        $gradesData["semester1"][$subjectId]["quarter_2_grade"] ?? "";
    $finalGrade = $gradesData["semester1"][$subjectId]["final_grade"] ?? "";

    $html .=
        '
                       <tr>
                           <td>' .
        $subject["subject_name"] .
        '</td>
                           <td align="center">' .
        $quarter1Grade .
        '</td>
                           <td align="center">' .
        $quarter2Grade .
        '</td>
                           <td align="center">' .
        $finalGrade .
        '</td>
                       </tr>';
}
// Close the table
$html .=
    '
            <!-- New row -->
            <tr>
               <td colspan="3" align="right">General Average for the Semester</td>
               <td align="center">' .
    $row["gen_avg_first"] .
    '</td>
            </tr>
         </table>
         <br>';
$html .= '
         <div>Second Semester</div>
         <table cellspacing="0" cellpadding="2" border="1" style="float:right;width:400px;">
            <tr align="center" style="font-weight: bold;">
               <td rowspan="2" width="320px;">&nbsp;<br>Subjects<br></td>
               <td colspan="2" width="70px;">Quarter</td>
               <td rowspan="2" width="80px;">Semester<br> Final Grades</td>
            </tr>
            <tr align="center" style="font-weight: bold;">
               <td>3</td>
               <td>4</td>
            </tr>
            <tr>
               <td colspan="4"><b>Core Subjects</b></td>
            </tr>';

foreach ($semesters[2]["core"] as $subject) {
    $subjectId = array_search(
        $subject["subject_id"],
        array_column($gradesData["semester2"], "subject_id")
    );
    $quarter1Grade =
        $gradesData["semester2"][$subjectId]["quarter_1_grade"] ?? "";
    $quarter2Grade =
        $gradesData["semester2"][$subjectId]["quarter_2_grade"] ?? "";
    $finalGrade = $gradesData["semester2"][$subjectId]["final_grade"] ?? "";

    $html .=
        '
                       <tr>
                           <td>' .
        $subject["subject_name"] .
        '</td>
                           <td align="center">' .
        $quarter1Grade .
        '</td>
                           <td align="center">' .
        $quarter2Grade .
        '</td>
                           <td align="center">' .
        $finalGrade .
        '</td>
                       </tr>';
}

$html .= '
           <tr>
              <td colspan="4"><b>Applied Subjects</b></td>
           </tr>';
foreach ($semesters[2]["applied"] as $subject) {
    $subjectId = array_search(
        $subject["subject_id"],
        array_column($gradesData["semester2"], "subject_id")
    );
    $quarter1Grade =
        $gradesData["semester2"][$subjectId]["quarter_1_grade"] ?? "";
    $quarter2Grade =
        $gradesData["semester2"][$subjectId]["quarter_2_grade"] ?? "";
    $finalGrade = $gradesData["semester2"][$subjectId]["final_grade"] ?? "";

    $html .=
        '
                    <tr>
                        <td>' .
        $subject["subject_name"] .
        '</td>
                        <td align="center">' .
        $quarter1Grade .
        '</td>
                        <td align="center">' .
        $quarter2Grade .
        '</td>
                        <td align="center">' .
        $finalGrade .
        '</td>
                    </tr>';
}
$html .=
    '
            <!-- New row -->
            <tr>
               <td colspan="3" align="right">General Average for the Semester</td>
               <td align="center">' .
    $row["gen_avg_second"] .
    '</td>
            </tr>
         </table>
      </td>
      <td>
         <h4 align="center">REPORT ON LEARNER\'S OBSERVED VALUES</h4>
         <div></div>
         <table cellspacing="0" cellpadding="2" border="1" align="left" style="float:right;width:400px;">
            <tr align="center" style="font-weight: bold;">
               <td rowspan="2" width="100px;">&nbsp;<br>Core Values<br></td>
               <td rowspan="2" width="230px;">&nbsp;<br>Behavior Statements<br></td>
               <td colspan="4" width="130px;">Quarter</td>
            </tr>
            <tr align="center" style="font-weight: bold;">
               <td>1</td>
               <td>2</td>
               <td>3</td>
               <td>4</td>
            </tr>
            <tr>
               <td rowspan="2">1. Maka-Diyos</td>
               <td>Expresses one\'s spiritual beliefs
                  while respecting the spiritual
                  beliefs of others
               </td>
               <td></td>
               <td></td>
               <td></td>
               <td></td>
            </tr>
            <tr>
               <td>Shows adherence to ethical
                  principles by upholding truth
               </td>
               <td></td>
               <td></td>
               <td></td>
               <td></td>
            </tr>
            <tr>
               <td rowspan="2">2. Makatao</td>
               <td>Is sensitive to individual, social,
                  and cultural differences
               </td>
               <td></td>
               <td></td>
               <td></td>
               <td></td>
            </tr>
            <tr>
               <td>Demonstrates contributions
                  towards solidarity
               </td>
               <td></td>
               <td></td>
               <td></td>
               <td></td>
            </tr>
            <tr>
               <td>3. Makakalikasan</td>
               <td>Cares for the environment and
                  utilizes resources wisely,
                  judiciously, and economically
               </td>
               <td></td>
               <td></td>
               <td></td>
               <td></td>
            </tr>
            <tr>
               <td rowspan="2">4. Makabansa</td>
               <td>Demonstrates pride in being a
                  Filipino; exercises the rights and
                  responsibilities of a Filipino
                  citizen
               </td>
               <td></td>
               <td></td>
               <td></td>
               <td></td>
            </tr>
            <tr>
               <td>Demonstrates appropriate
                  behavior in carrying out activities
                  in the school, community, and
                  country
               </td>
               <td></td>
               <td></td>
               <td></td>
               <td></td>
            </tr>
            <!-- New row -->
         </table>
         <div>
            <table cellspacing="0" cellpadding="2" border="0" align="left" style="float:right;width:400px;">
               <tr>
                  <td colspan="2"><b>Observed Values</b></td>
               </tr>
               <tr style="font-weight: bold;">
                  <td align="center">Marking</td>
                  <td>Non-numerical Rating</td>
               </tr>
               <tr>
                  <td align="center">AO</td>
                  <td>Always Observed</td>
               </tr>
               <tr>
                  <td align="center">SO</td>
                  <td>Sometimes Observed</td>
               </tr>
               <tr>
                  <td align="center">RO</td>
                  <td>Rarely Observed</td>
               </tr>
               <tr>
                  <td align="center">NO</td>
                  <td>Not Observed</td>
               </tr>
            </table>
            <table cellspacing="0" cellpadding="2" border="0" align="left" style="float:right;width:400px;">
               <tr>
                  <td colspan="3"><b>Learner Progress and Achievement</b></td>
               </tr>
               <tr style="font-weight: bold;">
                  <td>Descriptors </td>
                  <td align="center">Grading Scale</td>
                  <td align="center">Remarks</td>
               </tr>
               <tr>
                  <td>Outstanding</td>
                  <td align="center">90-100</td>
                  <td align="center">Passed</td>
               </tr>
               <tr>
                  <td>Very Satisfactory</td>
                  <td align="center">85-89</td>
                  <td align="center">Passed</td>
               </tr>
               <tr>
                  <td>Satisfactory</td>
                  <td align="center">80-84</td>
                  <td align="center">Passed</td>
               </tr>
               <tr>
                  <td>Fairly Satisfactory</td>
                  <td align="center">85-89</td>
                  <td align="center">Passed</td>
               </tr>
               <tr>
                  <td>Did Not Meet</td>
                  <td align="center">Below 75</td>
                  <td align="center">Failed</td>
               </tr>
            </table>
         </div>
      </td>
   </tr>
</table>
';
$pdf->writeHTML($html, true, false, false, false, "");
// -----------------------------------------------------------------------------

//Close and output PDF document
$pdf->Output('form138_'.$row["name"].'.pdf', 'D');
} else {
   // Handle the error when ID is not found
   die("Error: ID not found or invalid.");
}
