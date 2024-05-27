
$(document).ready(function () {
	$("#addFirstSemesterRow").click(function () {
		addRow("#firstSemesterTable tbody", "first_semester");
	});

	$("#addSecondSemesterRow").click(function () {
		addRow("#secondSemesterTable tbody", "second_semester");
	});

	$(document).on("click", ".removeRow", function () {
		$(this).closest("tr").remove();
	});

    $("#saveClassForm").submit(function (e) {
		e.preventDefault(); // Prevent the form from submitting traditionally

		var firstSemesterData = [];
		var secondSemesterData = [];

		$("#firstSemesterTable tbody tr").each(function () {
			var subject = $(this)
				.find('select[name^="subjects[first_semester]"]')
				.val();
			var teacher = $(this)
				.find('select[name^="teachers[first_semester]"]')
				.val();
			firstSemesterData.push({
				subject_id: subject,
				teacher_id: teacher,
			});
		});

		$("#secondSemesterTable tbody tr").each(function () {
			var subject = $(this)
				.find('select[name^="subjects[second_semester]"]')
				.val();
			var teacher = $(this)
				.find('select[name^="teachers[second_semester]"]')
				.val();
			secondSemesterData.push({
				subject_id: subject,
				teacher_id: teacher,
			});
		});

		var formData = {
			name: $('[name="name"]').val(),
			academic_year: $('[name="academic_year"]').val(),
			semesters: [
				{
					semester: 1,
					subjects: firstSemesterData,
				},
				{
					semester: 2,
					subjects: secondSemesterData,
				},
			],
		};

		var jsonData = JSON.stringify(formData);

		$.ajax({
			url: "code.php",
			method: "POST",
			data: {
				saveClass: true,
				classData: jsonData,
			}, // Form data
			dataType: "json",
			success: function (response) {
				if (response.success) {
					showAlert("success", response.message);
					$("#saveClassForm")[0].reset();
					$('select[name^="subjects"]').val("").trigger("change");
					$('select[name^="teachers"]').val("").trigger("change");
				} else {
					showAlert("warning", response.message);
				}
			},
		});
	});

    $("#updateClassForm").submit(function (e) {
		e.preventDefault(); // Prevent the form from submitting traditionally

		var firstSemesterData = [];
		var secondSemesterData = [];

		$("#firstSemesterTable tbody tr").each(function () {
			var subject = $(this)
				.find('select[name^="subjects[first_semester]"]')
				.val();
			var teacher = $(this)
				.find('select[name^="teachers[first_semester]"]')
				.val();
			firstSemesterData.push({
				subject_id: subject,
				teacher_id: teacher,
			});
		});

		$("#secondSemesterTable tbody tr").each(function () {
			var subject = $(this)
				.find('select[name^="subjects[second_semester]"]')
				.val();
			var teacher = $(this)
				.find('select[name^="teachers[second_semester]"]')
				.val();
			secondSemesterData.push({
				subject_id: subject,
				teacher_id: teacher,
			});
		});

		var formData = {
			classId: $('[name="classId"]').val(),
			name: $('[name="name"]').val(),
			academic_year: $('[name="academic_year"]').val(),
			semesters: [
				{
					semester: 1,
					subjects: firstSemesterData,
				},
				{
					semester: 2,
					subjects: secondSemesterData,
				},
			],
		};

		var jsonData = JSON.stringify(formData);

		$.ajax({
			url: "code.php",
			method: "POST",
			data: {
				updateClass: true,
				classData: jsonData,
			}, // Form data
			dataType: "json",
			success: function (response) {
				if (response.success) {
					showAlert("success", response.message);
				} else {
					showAlert("warning", response.message);
				}
			},
		});
	});
});
