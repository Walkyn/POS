import './bootstrap';
import "jsvectormap/dist/jsvectormap.css";
import "flatpickr/dist/flatpickr.min.css";
import "../css/app.css";
import 'flowbite';

import $ from 'jquery';
window.$ = window.jQuery = $;

import Alpine from "alpinejs";
import persist from "@alpinejs/persist";
import flatpickr from "flatpickr";
import { Spanish } from "flatpickr/dist/l10n/es";

import chart01 from "./components/chart-01";
import chart02 from "./components/chart-02";
import chart03 from "./components/chart-03";
import chart04 from "./components/chart-04";
import map01 from "./components/map-01";

Alpine.plugin(persist);
window.Alpine = Alpine;
Alpine.start();

// Init ripples
if (typeof window.$ !== 'undefined' && $('#ripple').length) {
  const script = document.createElement('script');
  script.src = '/js/jquery.ripples.min.js';
  script.onload = function () {
    if ($.fn.ripples) {
      try {
        $('#ripple').ripples({
          resolution: 512,
          dropRadius: 20,
          perturbance: 0.04,
        });
      } catch (error) {
        console.log('Error al inicializar ripples:', error);
      }
    }
  };
  script.onerror = function () {
    console.log('Error al cargar el script de ripples');
  };
  document.head.appendChild(script);
}

// Init flatpickr
flatpickr(".datepicker", {
  mode: "range",
  static: true,
  monthSelectorType: "static",
  dateFormat: "M j, Y",
  defaultDate: [new Date().setDate(new Date().getDate() - 6), new Date()],
  prevArrow:
    '<svg class="fill-current" width="7" height="11" viewBox="0 0 7 11"><path d="M5.4 10.8l1.4-1.4-4-4 4-4L5.4 0 0 5.4z" /></svg>',
  nextArrow:
    '<svg class="fill-current" width="7" height="11" viewBox="0 0 7 11"><path d="M1.4 10.8L0 9.4l4-4-4-4L1.4 0l5.4 5.4z" /></svg>',
  onReady: (selectedDates, dateStr, instance) => {
    // eslint-disable-next-line no-param-reassign
    instance.element.value = dateStr.replace("to", "-");
    const customClass = instance.element.getAttribute("data-class");
    instance.calendarContainer.classList.add(customClass);
  },
  onChange: (selectedDates, dateStr, instance) => {
    // eslint-disable-next-line no-param-reassign
    instance.element.value = dateStr.replace("to", "-");
  },
});

flatpickr(".form-datepicker", {
  mode: "single",
  dateFormat: "Y-m-d",
  locale: Spanish,
  onReady: (selectedDates, dateStr, instance) => {
    const customClass = instance.element.getAttribute("data-class");
    if (customClass && instance.calendarContainer) {
      instance.calendarContainer.classList.add(customClass);
    }
  },
  onChange: (selectedDates, dateStr, instance) => {
    instance.element.value = dateStr;
    instance.element.dispatchEvent(new Event('change', { bubbles: true }));
  },
});

// Document Loaded
document.addEventListener("DOMContentLoaded", () => {
  chart01();
  chart02();
  chart03();
  chart04();
  map01();
});