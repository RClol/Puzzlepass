const rooms =
    document.querySelectorAll(".puzzle-room");

const summaryRoom =
    document.getElementById("summaryRoom");

const summaryPrice =
    document.getElementById("summaryPrice");

let selectedRoom = rooms[0];


//Escape room selecteren

rooms.forEach(room => {

    const button =
        room.querySelector(".room-select");


    button.addEventListener("click", () => {

        
         //Alle kamers resetten
         

        rooms.forEach(item => {

            item.classList.remove("selected");

            const itemButton =
                item.querySelector(".room-select");

            itemButton.classList.remove("selected");

            itemButton.textContent =
                "Selecteren";

        });


        
         //Gekozen kamer selecteren
         

        room.classList.add("selected");

        button.classList.add("selected");

        button.textContent =
            "Geselecteerd ✓";


        
         //Geselecteerde kamer opslaan
         

        selectedRoom = room;


        
         //Summary aanpassen
         

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


//kalender

const calendarDays =
    document.getElementById(
        "calendarDays"
    );

const monthTitle =
    document.getElementById(
        "monthTitle"
    );


//Begin bij oktober 2026
 

let calendarDate =
    new Date(2026, 9, 1);



let selectedDate = null;



function renderCalendar() {

    
     //Oude kalender leegmaken
     

    calendarDays.innerHTML = "";


    
     //Jaar en maand ophalen
     

    const year =
        calendarDate.getFullYear();

    const month =
        calendarDate.getMonth();


    
     //Eerste en laatste dag
     

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
     * hier gebruikt:
     * maandag = 0
     */

    let startingDay =
        firstDay.getDay();


    startingDay =
        startingDay === 0
            ? 6
            : startingDay - 1;


    
      //naam van de maand laten zien
     

    monthTitle.textContent =
        calendarDate.toLocaleDateString(
            "nl-NL",
            {
                month: "long",
                year: "numeric"
            }
        );


    
     //Lege vakken voor eerste week
    

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


    
     //Vandaag bepalen
     

    const today =
        new Date();

    today.setHours(
        0,
        0,
        0,
        0
    );


    
     //Alle dagen maken
     

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


        
         //Datum van deze dag
         

        const current =
            new Date(
                year,
                month,
                day
            );


        
         //Dagen uit het verleden uitschakelen
        

        if (current < today) {

            dayButton.classList.add(
                "disabled"
            );

            dayButton.disabled =
                true;

        }


        
         //gekozen datum markeren
         

        if (
            selectedDate &&
            current.toDateString() ===
            selectedDate.toDateString()
        ) {

            dayButton.classList.add(
                "selected"
            );

        }


        
         
         

        dayButton.addEventListener(
            "click",
            () => {

                selectedDate =
                    current;


                
                 //Kalender opnieuw tekenen zodat keuze zichtbaar wordt
                 

                renderCalendar();


                
                 //updaten
                 

                updateBooking();

            }
        );


        calendarDays.appendChild(
            dayButton
        );

    }

}


//vorige maand

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


//Komende maand

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


//timeslots

const timeSlots =
    document.querySelectorAll(
        ".time-slot"
    );


let selectedTime = null;


//timeslot select

timeSlots.forEach(slot => {

    slot.addEventListener(
        "click",
        () => {

            //deselect all

            timeSlots.forEach(item => {

                item.classList.remove(
                    "selected"
                );

            });


            //mark selected

            slot.classList.add(
                "selected"
            );


            //save time

            selectedTime =
                slot.dataset.time;


            //update

            updateBooking();

        }
    );

});


// Summary

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


    //date

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


    //time

    if (selectedTime) {

        timeText.textContent =
            selectedTime +
            " · 1,5 uur";

    } else {

        timeText.textContent =
            "Kies een tijd";

    }


    //button alleen actief wanneer: datum gekozen is, tijd gekozen is

    bookingButton.disabled =
        !selectedDate ||
        !selectedTime;

}



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


        //gekozen escape room

        const roomName =
            selectedRoom.dataset.room;


        //prijs

        const price =
            selectedRoom.dataset.price;


        // datum naar nl

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


        //link naar boekenphp

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


        

        window.location.href =
            url;

    }
);



renderCalendar();




updateBooking();