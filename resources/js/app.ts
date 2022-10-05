Array.from(document.querySelectorAll("form[loader-on-submit]")).forEach(el => {
    el.addEventListener("submit", e => {
        // e.preventDefault()
        // let target = e.currentTarget as HTMLFormElement
        //
        // while (target && !target.classList.contains("chewby__loader")) {
        //     console.log(target)
        //     target = target.parentNode
        // }

        // loader.style.display = "flex"
    })
})

/**
 * Applied on: input-button
 * Set input margin right to fit button width
 */
Array.from(document.querySelectorAll(".chewby__input--button")).forEach((el) => {
    const input = el.querySelector("input") as HTMLInputElement;
    if (!input) {
        throw new Error(
            'Element ".chewby__input--button" need to have a HTMLInputElement children'
        );
    }
    const button = el.querySelector("button");
    if (!button) {
        throw new Error(
            'Element ".chewby__input--button" need to have a HTMLButtonElement children'
        );
    }
    const width = button.getClientRects()[0]["width"];
    input.style.paddingRight = width + 10 + "px"; //Adding 10 because of the button rigth/left padding and the little right "margin"
});

/**
 * Applied on: chewby__notification
 * Close notification when close icon is clicked or after 2mn
 */
Array.from(document.querySelectorAll(".chewby__notification__icon--close")).forEach((el) => {
    const removeElement = () => {
        el.removeEventListener("click", removeElement)
        const notification = el.parentNode as HTMLElement
        if (!notification.classList.contains("chewby__notification")) {
            throw new Error("Chewby notification need to be in this format : " +
                "<svg class='icon chewby__notification__icon' />" +
                "<span class='icon chewby__notification__content' />" +
                "</span>" +
                "<svg class='icon chewby__notification__icon--close' />" +
                "</div>")
        }
        notification.parentNode!!.removeChild(notification)
    }
    window.setTimeout(removeElement, 1000 * 60 * 2)
    el.addEventListener("click", removeElement)
})
