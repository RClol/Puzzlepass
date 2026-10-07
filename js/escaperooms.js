const rooms =
    document.querySelectorAll(".puzzle-room");

const summaryRoom =
    document.getElementById("summaryRoom");

const summaryPrice =
    document.getElementById("summaryPrice");

let selectedRoom = rooms[0];


/*
 * Escape room selecteren
 */

rooms.forEach(room => {

    const button =
        room.querySelector(".room-select");


    button.addEventListener("click", () => {

        /*
         * Alle kamers resetten
         */

        rooms.forEach(item => {

            item.classList.remove("selected");

            const itemButton =
                item.querySelector(".room-select");

            itemButton.classList.remove("selected");

            itemButton.textContent =
                "Selecteren";

        });


        /*
         * Gekozen kamer selecteren
         */

        room.classList.add("selected");

        button.classList.add("selected");

        button.textContent =
            "Geselecteerd ✓";


        /*
         * Geselecteerde kamer opslaan
         */

        selectedRoom = room;


        /*
         * Summary aanpassen
         */

        summaryRoom.textContent =
            room.dataset.room;


        summaryPrice.textContent =
            "€" +
            room.dataset.price.replace(
                ".",
                ","
            );

    });

});


/* =========================================
   KALENDER
========================================= */

const calendarDays =
    document.getElementById(
        "calendarDays"
    );

const monthTitle =
    document.getElementById(
        "monthTitle"
    );


/*
 * Begin bij oktober 2026
 */

let calendarDate =
    new Date(2026, 9, 1);


/*
 * Geselecteerde datum
 */

let selectedDate = null;


/* =========================================
   KALENDER RENDEREN
========================================= */

function renderCalendar() {

    /*
     * Oude kalender leegmaken
     */

    calendarDays.innerHTML = "";


    /*
     * Jaar en maand ophalen
     */

    const year =
        calendarDate.getFullYear();

    const month =
        calendarDate.getMonth();


    /*
     * Eerste en laatste dag
     */

    const firstDay =
        new Date(
            year,
            month,
            1
        );

    const lastDay =
        new Date(
            year,
            month + 1,
            0
        );


    /*
     * Eerste weekdag bepalen
     *
     * JavaScript:
     * zondag = 0
     * maandag = 1
     *
     * Wij gebruiken:
     * maandag = 0
     */

    let startingDay =
        firstDay.getDay();


    startingDay =
        startingDay === 0
            ? 6
            : startingDay - 1;


    /*
     * Maandnaam tonen
     */

    monthTitle.textContent =
        calendarDate.toLocaleDateString(
            "nl-NL",
            {
                month: "long",
                year: "numeric"
            }
        );


    /*
     * Lege vakken voor eerste week
     */

    for (
        let i = 0;
        i < startingDay;
        i++
    ) {

        const empty =
            document.createElement(
                "span"
            );

        empty.classList.add(
            "empty"
        );

        calendarDays.appendChild(
            empty
        );

    }


    /*
     * Vandaag bepalen
     */

    const today =
        new Date();

    today.setHours(
        0,
        0,
        0,
        0
    );


    /*
     * Alle dagen maken
     */

    for (
        let day = 1;
        day <= lastDay.getDate();
        day++
    ) {

        const dayButton =
            document.createElement(
                "button"
            );


        dayButton.type =
            "button";

        dayButton.textContent =
            day;


        /*
         * Datum van deze dag
         */

        const current =
            new Date(
                year,
                month,
                day
            );


        /*
         * Dagen uit het verleden
         * uitschakelen
         */

        if (current < today) {

            dayButton.classList.add(
                "disabled"
            );

            dayButton.disabled =
                true;

        }


        /*
         * Geselecteerde datum markeren
         */

        if (
            selectedDate &&
            current.toDateString() ===
            selectedDate.toDateString()
        ) {

            dayButton.classList.add(
                "selected"
            );

        }


        /*
         * Datum aanklikken
         */

        dayButton.addEventListener(
            "click",
            () => {

                selectedDate =
                    current;


                /*
                 * Kalender opnieuw tekenen
                 * zodat selectie zichtbaar wordt
                 */

                renderCalendar();


                /*
                 * Summary updaten
                 */

                updateBooking();

            }
        );


        calendarDays.appendChild(
            dayButton
        );

    }

}


/* =========================================
   VORIGE MAAND
========================================= */

const previousMonth =
    document.getElementById(
        "previousMonth"
    );


previousMonth.addEventListener(
    "click",
    () => {

        calendarDate.setMonth(
            calendarDate.getMonth() - 1
        );


        renderCalendar();

    }
);


/* =========================================
   VOLGENDE MAAND
========================================= */

const nextMonth =
    document.getElementById(
        "nextMonth"
    );


nextMonth.addEventListener(
    "click",
    () => {

        calendarDate.setMonth(
            calendarDate.getMonth() + 1
        );


        renderCalendar();

    }
);


/* =========================================
   TIJDSLOTS
========================================= */

const timeSlots =
    document.querySelectorAll(
        ".time-slot"
    );


let selectedTime = null;


/*
 * Tijdslot selecteren
 */

timeSlots.forEach(slot => {

    slot.addEventListener(
        "click",
        () => {

            /*
             * Alle tijdslots deselecteren
             */

            timeSlots.forEach(item => {

                item.classList.remove(
                    "selected"
                );

            });


            /*
             * Geselecteerde tijd markeren
             */

            slot.classList.add(
                "selected"
            );


            /*
             * Tijd opslaan
             */

            selectedTime =
                slot.dataset.time;


            /*
             * Summary updaten
             */

            updateBooking();

        }
    );

});


/* =========================================
   BOOKING SUMMARY
========================================= */

function updateBooking() {

    const dateText =
        document.getElementById(
            "summaryDate"
        );

    const timeText =
        document.getElementById(
            "summaryTime"
        );

    const bookingButton =
        document.getElementById(
            "bookingButton"
        );


    /*
     * DATUM
     */

    if (selectedDate) {

        dateText.textContent =
            selectedDate.toLocaleDateString(
                "nl-NL",
                {
                    weekday: "long",
                    day: "numeric",
                    month: "long",
                    year: "numeric"
                }
            );

    } else {

        dateText.textContent =
            "Kies een datum";

    }


    /*
     * TIJD
     */

    if (selectedTime) {

        timeText.textContent =
            selectedTime +
            " · 1,5 uur";

    } else {

        timeText.textContent =
            "Kies een tijd";

    }


    /*
     * BOOKING BUTTON
     *
     * Alleen actief wanneer:
     * - datum gekozen is
     * - tijd gekozen is
     */

    bookingButton.disabled =
        !selectedDate ||
        !selectedTime;

}


/* =========================================
   DOORGAAN NAAR BOEKEN
========================================= */

const bookingButton =
    document.getElementById(
        "bookingButton"
    );


bookingButton.addEventListener(
    "click",
    () => {

        /*
         * Veiligheidscontrole
         */

        if (
            !selectedDate ||
            !selectedTime
        ) {

            return;

        }


        /*
         * Geselecteerde escape room
         */

        const roomName =
            selectedRoom.dataset.room;


        /*
         * Prijs
         */

        const price =
            selectedRoom.dataset.price;


        /*
         * Datum omzetten naar Nederlandse tekst
         */

        const date =
            selectedDate.toLocaleDateString(
                "nl-NL",
                {
                    weekday: "long",
                    day: "numeric",
                    month: "long",
                    year: "numeric"
                }
            );


        /*
         * URL naar boeken.php
         */

        const url =
            "boeken.php" +
            "?room=" +
            encodeURIComponent(
                roomName
            ) +
            "&date=" +
            encodeURIComponent(
                date
            ) +
            "&time=" +
            encodeURIComponent(
                selectedTime
            ) +
            "&price=" +
            encodeURIComponent(
                price
            );


        /*
         * Naar booking pagina
         */

        window.location.href =
            url;

    }
);


/* =========================================
   KALENDER STARTEN
========================================= */

renderCalendar();


/*
 * Booking summary initialiseren
 */

updateBooking();