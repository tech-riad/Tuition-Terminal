<script>


$(function () {
        $("#parentNote").on("submit", function (event) {
            event.preventDefault();


            const formElement = document.getElementById('parentNote');
             const formData = new FormData(formElement);

             const parent_id = formData.get('parent_id');
             var csrfToken = document.querySelector('meta[name="csrf-token"]').getAttribute('content');


            $.ajax({
                url: $(this).attr("action"),
                method: $(this).attr("method"),
                data: new FormData(this),
                processData: false,
                datatype: JSON,
                contentType: false,
                headers: {
                         'X-CSRF-TOKEN': csrfToken
                         },

                success: function (response) {

                    Swal.fire({
                                position: "top-end",
                                icon: "success",
                                title: "note added successfully",
                                showConfirmButton: false,
                                timer: 1500,
                            });
                    $("#parentNote")[0].reset();


                    btnNote(parent_id);
                //    console.log(response);
                },

                error: function (err) {
                    let error = err.responseJSON;
                    console.log(error);
                },
            });
        });
    });


    $.date = function(dateObject) {
    const myArray = dateObject.split("T");
    var d = new Date(myArray[0]);
    var day = d.getDate();
    var month = d.getMonth() + 1;
    var year = d.getFullYear();
    if (day < 10) {
        day = "0" + day;
    }
    if (month < 10) {
        month = "0" + month;
    }
    var date = day + "-" + month + "-" + year;

    return date;
};


    function btnNote(id){


        $('#note_parent_id').val(id);

        //  console.log(id);

             $.ajax({
                url:'{{route("admin.parent.getnote")}}',
                type:'get',
                data: {
                       id:id,
                       },
                success:function (response){

                    let html ='';

                    var notes = response.data
                    for(i=0 ; i<notes.length; i++){

                        // console.log(notes[i].body);

                  html+= ' <div class="border-bottom border-1 pb-3">\
                                            <div class="bg-light rounded-2 p-2" style="font-size: 14px">\
                                                Lorem ipsum dolor sit amet consectetur adipisicing\
                                                elit. Perspiciatis, dignissimos.\
                                            </div>\
                                        </div>\
                                        <div class="d-flex justify-content-between align-items-center mt-3">\
                                            <div class="d-flex justify-content-start align-items-center gap-3">\
                                                <img height="45" width="45" class="rounded-3"\
                                                    src="/images/avatar.svg" alt="" />\
                                                <div class="">\
                                                    <p class="m-0" style="font-size: 14; font-weight: 500">\
                                                        Kaji Polash\
                                                    </p>\
                                                    <p class="m-0 fw-light" style="font-size: 12px">\
                                                        Sales & Operation Dep:\
                                                    </p>\
                                                </div>\
                                            </div>\
                                            <div>\
                                                <p style="font-size: 12px">12:30 PM 21-01-2023</p>\
                                            </div>\
                                        </div>';

                }


                    $('#noteModal').html(html);



                }
            });

}


$(function(e){
    $("#select_all").click(function(){
      $('.checkboxx').prop('checked',$(this).prop('checked'));
    });

    $("#sendSms").click(function(e){
       e.preventDefault();
       var all_ids =[];

       $('input:checkbox[name=ids]:checked').each(function(){
        all_ids.push($(this).val());
       });

       $("#var1").val(all_ids);
       console.log(all_ids);
       if(all_ids == ''){
            alert("please select atleast one parents");
           }
         else{
          $("#smsForm").submit();
           }


    });

  });

  function dateTime(dateTime){

      let xx = dateTime;
      const myArray = xx.split(" ");

      let date = new Date(myArray[0]);
      let year = new Intl.DateTimeFormat('en', { year: 'numeric' }).format(date);
      let month = new Intl.DateTimeFormat('en', { month: 'short' }).format(date);
      let day = new Intl.DateTimeFormat('en', { day: '2-digit' }).format(date);

      let time = myArray[1];

      var hour = parseInt(time.split(":")[0]) % 12;
      var timeInAmPm = (hour == 0 ? "12": hour ) + ":" + time.split(":")[1] + " " + (parseInt(parseInt(time.split(":")[0]) / 12) < 1 ? "am" : "pm");

      $("#date").text(`${day} ${month} ${year}`);
      $("#time").text(timeInAmPm);

      }

      $('#checkbox').on('click', function() {

            // let value = $(this).val();
            if (this.checked) {
                console.log('on');
            } else {
                console.log('off');
            }
        })

function btnEdit(id){

var route = '{{ route("parent.edit", ":id") }}';
route = route.replace(':id', id);

$.ajax({
  type: "GET",
  url: route,
  success:function(response){
     $('#parent_id').val(response.parent.id);
     $('#name').val(response.parent.name);
     $('#email').val(response.parent.email);
     $('#phone').val(response.parent.phone);
     $('#additional_phone').val(response.parent.additional_phone);
  }
});
}
























//  var checkboxes = document.querySelectorAll('.checkbox');

//  function selectAll(){

//     var checkboxes = document.querySelectorAll('.checkbox');

//     for(var checkbox of checkboxes){
//         checkbox.checked = this.checked;
//     }
//     console.log('hi');



// }

function selectAll(source) {
var checkboxes = document.querySelectorAll('.checkbox');
var count =0;
for (var i = 0; i < checkboxes.length; i++) {

    if (checkboxes[i] != source){
        checkboxes[i].checked = source.checked;

        if (checkboxes[i].checked == true){
        count ++;
        document.getElementById('selected').innerHTML = count;}
    }
    else{
        count = 0;
        document.getElementById('selected').innerHTML = count;

    }
}


}






// for(var i=0; i < checkboxes.length ;i++){
//     checkboxes[i].addEventListener('click',function(){
//         if(this.checked == true){
//             count ++;
//         }
//         else{
//             count -- ;
//         }
//         document.getElementById('selected').innerHTML = count;

//     })
// }




</script>
