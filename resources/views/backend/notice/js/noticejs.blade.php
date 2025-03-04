<script>
    document.addEventListener('DOMContentLoaded', function () {
        let userTypeSelect = document.getElementById('userType');
        let filterTutorsModal = document.getElementById('filterTutorsModal');

        // Restore the selected user type when the page loads
        let savedUserType = localStorage.getItem('selectedUserType');
        if (savedUserType) {
            userTypeSelect.value = savedUserType;
        }

        userTypeSelect.addEventListener('change', function () {
            let selectedValue = this.value;
            localStorage.setItem('selectedUserType', selectedValue); 

            if (selectedValue === 'tutor') {
                let modal = new bootstrap.Modal(filterTutorsModal);
                modal.show();
            }
        });

        // When the modal opens, set the selected option in the dropdown
        filterTutorsModal.addEventListener('shown.bs.modal', function () {
            let savedUserType = localStorage.getItem('selectedUserType');
            if (savedUserType) {
                userTypeSelect.value = savedUserType;
            }
        });
    });
</script>

<script>
    $(document).ready(function () {
    $('#applyFilter').on('click', function () {
        let dateFrom = $('#datef').val();
        let dateTo = $('#datet').val();
        let country = $('#country').val();
        let city = $('#city').val();
        let teachingMethod = $('#teachingMethod').val();
        let gender = $('#gender').val();
        let subjects = $('#subjects').val();
        let category = $('#category').val();

        $.ajax({
            url: "{{ route('admin.all.notice.tutor.filter') }}",
            method: "POST",
            data: {
                date_from: dateFrom,
                date_to: dateTo,
                country: country,
                city: city,
                teaching_method: teachingMethod,
                gender: gender,
                subjects: subjects,
                category: category,
                _token: "{{ csrf_token() }}"
            },
            dataType: "json",
            success: function (response) {
                if (response.status === 'success') {
                    let numbers = response.numbers.map(num => num + ',').join('\n');
                    $('#selectNumbers').val(numbers);

                    $('#audience').html('Audience: ' + response.count);

                    $('#filterTutorsModal').modal('hide');
                } else {
                    alert('No numbers found');
                }
            },
            error: function (xhr, status, error) {
                console.error(xhr.responseText);
                alert('Something went wrong! Check console for details.');
            }
        });
    });
});


</script>


