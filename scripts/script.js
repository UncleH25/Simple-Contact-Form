// Wait for the DOM to fully load
document.addEventListener("DOMContentLoaded", () => {
    // Get the form element
    const contactForm = document.querySelector("form");

    // Add an event listener for form submission
    contactForm.addEventListener("submit", (event) => {
        event.preventDefault(); // Prevent the default form submission behavior

        // Get form field values
        const name = document.getElementById("name").value.trim();
        const email = document.getElementById("email").value.trim();
        const phoneNumber = document.getElementById("phone number").value.trim();
        const message = document.getElementById("message").value.trim();

        // Validate form fields
        if (!name || !email || !message) {
            alert("Please fill out all required fields.");
            return;
        }

        // Prepare form data for submission
        const formData = new FormData(contactForm);

        // Send the form data to the backend using Fetch API
        fetch(contactForm.action, {
            method: contactForm.method,
            body: formData,
        })
            .then((response) => {
                if (response.ok) {
                    return response.text();
                } else {
                    throw new Error("Failed to submit the form.");
                }
            })
            .then((data) => {
                // Provide user feedback
                alert("Thank you for your message!");
                console.log("Server response:", data);

                // Clear the form fields
                contactForm.reset();
            })
            .catch((error) => {
                console.error("Error:", error);
                alert("An error occurred while submitting the form. Please try again.");
            });
    });
});