let feedbackBtn = document.getElementById("feedbackBtn");
let shareFeedback = document.getElementById("shareFeedback");
let feedbackSlide1 = document.getElementById("slide1");
let feedbackSlide2 = document.getElementById("slide2");
let feedbackTextarea = document.getElementById("feedbackContent");
let feedbackBackBtn = document.getElementById("feedbackBackBtn");

let feedbackMsg = "";

feedbackBtn.addEventListener("click", () => {
  feedbackSlide1.style.width = "0vw";
  feedbackSlide2.style.width = "100vw";
});

shareFeedback.addEventListener("click", () => {
  feedbackMsg = feedbackTextarea.value + "";
  feedbackTextarea.value = "";
  let alertMsg = "";
  if (feedbackMsg.length == 0) {
    alertMsg = "Please write a feedback message to share!";
    alert(alertMsg);
    return;
  }

  shareFeedbackMail(feedbackMsg);
  alertMsg = "Feedback sent!\nThank you for sharing your feedback:)";
  alert(alertMsg);
  feedbackSlide1.style.width = "100vw";
  feedbackSlide2.style.width = "0vw";
});

feedbackBackBtn.addEventListener("click", () => {
  feedbackSlide1.style.width = "100vw";
  feedbackSlide2.style.width = "0vw";
  feedbackTextarea.value = "";
});

function shareFeedbackMail(msg) {
  Email.send({
    SecureToken: "cea665f0-f786-4cee-b1b8-fd14858636d1",
    To: "prasantpoddar27@gmail.com",
    From: "prasantpoddar27@gmail.com",
    Subject: "PMS Project Feedback",
    Body: msg,
  }).then((message) => alert(message));
}
