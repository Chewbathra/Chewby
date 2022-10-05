Array.from(document.querySelectorAll("form[loader-on-submit]")).forEach(el => {
    el.addEventListener("submit", e => {
        const target = e.currentTarget as HTMLFormElement
        try {
            const loader = getElementBasedOnClassInSiblingAndParentElements(target, "chewby__loader")
            loader.classList.add("chewby__loader--display")
        } catch (e) {
            throw new Error("You need to have a loader with class chewby__loader in your page !")
        }
    })
})

/**
 * Search element with specific class in the siblings and parent recursively.
 * !!! Search recursively in parents but not in siblings !!!
 * @param node HTMLElement where to perform search
 * @param classToSearch
 */
function getElementBasedOnClassInSiblingAndParentElements(node: HTMLElement, classToSearch: string): HTMLElement {
    if (node.classList.contains(classToSearch)) {
        return node
    }
    let nextSiblingNode = node.nextElementSibling as HTMLElement
    let previousSiblingNode = node.previousElementSibling as HTMLElement
    let parentNode = node.parentNode as HTMLElement
    if (nextSiblingNode && nextSiblingNode.classList.contains(classToSearch)) {
        return nextSiblingNode
    }
    if (previousSiblingNode && previousSiblingNode.classList.contains(classToSearch)) {
        return previousSiblingNode
    }
    if (parentNode && parentNode.classList.contains(classToSearch)) {
        return parentNode
    }
    return getElementBasedOnClassInSiblingAndParentElements(parentNode, classToSearch)
}

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
