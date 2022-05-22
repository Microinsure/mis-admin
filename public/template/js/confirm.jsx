$(document).ready(() => {
    $("#new_bursary_table,#new_projects_table").DataTable({
      pageLength: 5,
      dom: 'Bfrtip',
            buttons: [
                'excelHtml5',
                'csvHtml5',
                'pdfHtml5'
            ]
    })
  })

  function PromptApproval(ID, OBJECT) {
    $.confirm({
      title: 'Confirm!',
      content: `Are you sure you would like to Approve this new ${OBJECT} with reference of ${ID}?`,
      type: 'red',
      typeAnimated: true,
      buttons: {
        confirm: function () {
          Approve(ID, OBJECT)
        },
        cancel: function () {
          $.alert('Canceled!');
        },

      }
    });
  }
  async function Approve(reference, object) {
    var self = this;
    const options = {
      method: "PUT",
      headers: {
        "Content-Type": "application/json"
      },
      body: JSON.stringify({ reference, object })
    }
    let response = await fetch(`${BASE_URL}/approve`, options)
    response = await response.json()
    let type = (response.status == "success" ? "green" : "red")
    $.alert({
      title: response.status,
      type,
      content: response.message
    })
    setTimeout(() => { location.reload() }, 3000)
  }

  async function RejectPrompt(ID, Object) {
    $.confirm({
      title: 'Reject '+Object+': ' + ID,
      content: '' +
        '<form action="" class="formName">' +
        '<div class="form-group">' +
        '<label><b>Reason for Rejection:</b></label>' +
        '<textarea placeholder="Write Here..." rows="5" class="justification form-control" /></textarea>' +
        '</div>' +
        '</form>',
      buttons: {
        formSubmit: {
          text: 'Reject',
          btnClass: 'btn-red',
          action: function () {
            var justification = this.$content.find('.justification').val();
            if (!justification) {
              $.alert('Provide a valid justification');
              return false;
            }
            Reject(ID, Object, justification)
            //$.alert('Your justification is: ' + justification);
          }
        },
        cancel: function () {
          //close
        },
      },
      onContentReady: function () {
        // bind to events
        var jc = this;
        this.$content.find('form').on('submit', function (e) {
          // if the user submits the form by pressing enter in the field.
          e.preventDefault();
          jc.$$formSubmit.trigger('click'); // reference the button and click it
        });
      }
    });
  }

  async function Reject(reference, object, justification) {
    var self = this;
    const options = {
      method: "PUT",
      headers: {
        "Content-Type": "application/json"
      },
      body: JSON.stringify({ reference, object, justification })
    }
    let response = await fetch(`${BASE_URL}/reject`, options)
    response = await response.json()
    let type = (response.status == "success" ? "green" : "red")
    $.alert({
      title: response.status,
      type,
      content: response.message
    })

    setTimeout(() => { location.reload() }, 3000)
  }