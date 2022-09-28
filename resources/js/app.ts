/**
 * Applied on: input-button
 * Set input margin right to fit button width
 */
Array.from(document.querySelectorAll(".chewby__input--button")).forEach((el) => {
    const input = el.querySelector("input");
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
