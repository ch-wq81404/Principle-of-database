/*---LEFT BAR ACCORDION----*/
$(function() {
    $('#nav-accordion').dcAccordion({
        eventType: 'click',
        autoClose: true,
        saveState: true,
        disableLink: true,
        speed: 'slow',
        showCount: false,
        autoExpand: true,
        classExpand: 'dcjq-current-parent'
    });
});

var Script = function () {

    jQuery('#sidebar .sub-menu > a').click(function () {
        var o = ($(this).offset());
        diff = 250 - o.top;
        if(diff>0)
            $("#sidebar").scrollTo("-="+Math.abs(diff),500);
        else
            $("#sidebar").scrollTo("+="+Math.abs(diff),500);
    });


   
};

//计算成绩
  function calc() {
            // 查找该行中的文本框
            var inputs = $(event.target).parent().parent().find('input');
            var input1 = inputs.eq(0);
            var input2 = inputs.eq(1);
            // 检查成绩的有效性
            if (!checkNumber(input1.val())) {
                input1.addClass('error');
                setTimeout(function () { input1.removeClass('error') }, 3000);
                return;
            }
            if (!checkNumber(input2.val())) {
                input2.addClass('error');
                setTimeout(function () { input2.removeClass('error') }, 3000);
                return;
            }
            // 计算总成绩
            inputs.eq(2).val((parseFloat(input1.val()) * 0.3 + parseFloat(input2.val()) * 0.7).toFixed(2));
        }
//提交
 function saveScore() {
            var inputs, input1, input2, input3;
            var success = true;
            $("#scoreTable tr:has('input')").each(function (index, elem) {
                inputs = $(elem).find('input');
                input1 = inputs.eq(0);
                input2 = inputs.eq(1);
                input3 = inputs.eq(2);
                // 检查成绩的有效性
                if (!checkNumber(input1.val())) {
                    input1.addClass('error');
                    setTimeout(function () { input1.removeClass('error') }, 3000);
                    success = false;
                    // 在each()方法中如果return false，则退出所有循环
                    return false;
                }
                if (!checkNumber(input2.val())) {
                    input2.addClass('error');
                    setTimeout(function () { input2.removeClass('error') }, 3000);
                    success = false;
                    // 在each()方法中如果return false，则退出所有循环
                    return false;
                }
                // 根据表格中的数据更新students数据
                students[index].score1 = parseFloat(input1.val()).toFixed(2);
                students[index].score2 = parseFloat(input2.val()).toFixed(2);
                students[index].score3 = parseFloat(input3.val()).toFixed(2);
            });
            if (success) {
                console.log(students);
                // 实际应用时，将students数据上传给服务器即可
            }
        }






