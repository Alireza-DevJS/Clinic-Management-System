
document
  .querySelectorAll(".services-contact-custom-select")
  .forEach((customSelect) => {
    const selectBtn = customSelect.querySelector(
      ".services-contact-custom-select-btn"
    );

    const selectText = customSelect.querySelector(
      ".services-contact-custom-select-btn span"
    );

    const options = customSelect.querySelectorAll(
      ".services-contact-custom-select-options li"
    );

    selectBtn.addEventListener("click", () => {
      customSelect.classList.toggle("active");
    });

    options.forEach((option) => {
      if (
        option.classList.contains(
          "services-contact-custom-select-option-disable"
        )
      ) {
        return;
      }

      option.addEventListener("click", () => {
        selectText.textContent = option.textContent.trim();
        customSelect.classList.remove("active");
      });
    });

    document.addEventListener("click", (e) => {
      if (!customSelect.contains(e.target)) {
        customSelect.classList.remove("active");
      }
    });
  });

const input = document.getElementById("services-num-input");

if (input) {
  input.addEventListener("input", () => {
    input.value = input.value.replace(/\D/g, "");
  });
}