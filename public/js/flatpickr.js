function handleChange(selectedDates, dateStr, instance) {
    console.log({ selectedDates, dateStr, instance });
    const selectedDate = selectedDates[0];
    const dayOfWeek = selectedDate.getDay(); // 0 = Sunday, 1 = Monday, ..., 6 = Saturday
    let minTime = null;

    switch (dayOfWeek) {
        case 0: // Sunday
        case 5: // Friday
        case 6: // Saturday
            minTime = "12:00"; // 12 PM
            break;
        case 3: // Wednesday
            minTime = "17:00"; // 5 PM
            break;
        case 4: // Thursday
            minTime = "12:00"; // 12 PM
            break;
        default: // Monday and Tuesday (Closed)
            instance.close(); // Close the calendar for closed days
            // alert("Gesloten (Closed) on this day.");
            return;
    }

    // Set the new minTime for Flatpickr
    instance.set("minTime", minTime);
    console.log(`Min time set to: ${minTime}`);
}
document.addEventListener('livewire:navigated', function() {
    flatpickr("#flatPickr", {
        enableTime: true,
        maxTime: "20:30",
        time_24hr: true,
        minuteIncrement: 15,
        onChange: handleChange,
        dateFormat: "d-m-Y H:i",
        minDate: "today",
        disable: [
            function (date) {
                // return true to disable
                return (date.getDay() === 1 || date.getDay() === 2); // Disable Mondays and Tuesdays
            }
        ],
        onClose: function () {
            onClose();
        }
    });
});
