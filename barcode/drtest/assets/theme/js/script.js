(function () {
    function findElements(container, selector) {
      // Use Array.from to ensure compatibility with older browsers
      return Array.from(container.querySelectorAll(selector));
    }
  
    function getBoundingClientRect(element) {
      return element.getBoundingClientRect();
    }
  
    function getElementHeight(element) {
      return parseFloat(getComputedStyle(element).height.replace('px', ''));
    }
  
    function getElementWidth(element) {
      return parseFloat(getComputedStyle(element).width.replace('px', ''));
    }
  
    function onDocumentReady(callback) {
      document.addEventListener('DOMContentLoaded', callback);
    }
  
    function hideElement(element) {
      element.style.opacity = 0;
      element.style.display = 'none';
    }
  
    function showElement(element) {
      element.style.display = 'block';
      element.style.opacity = 1;
    }
  
    function isMobile() {
      const userAgent = navigator.userAgent.toLowerCase();
      const mobilePlatforms = ['blackberry', 'android', 'iemobile', 'opera mini', 'ios'];
      return mobilePlatforms.some(platform => userAgent.includes(platform));
    }
  
    function activateCarousel(carouselElement) {
      const carouselId = carouselElement.getAttribute('id') || carouselElement.classList.value.match(/cid-.*?(?=\s|$)/)[1];
      carouselElement.querySelectorAll('.carousel').forEach(item => item.setAttribute('id', carouselId));
  
      carouselElement.querySelectorAll('.carousel-controls a').forEach(link => {
        link.setAttribute('href', `#${carouselId}`);
      });
  
      carouselElement.querySelectorAll('.carousel-indicators > li').forEach(indicator => {
        indicator.setAttribute('data-target', `#${carouselId}`);
      });
  
      findElements(carouselElement, '.carousel-item')[0].classList.add('active');
      findElements(carouselElement, '.carousel-indicators > li')[0].classList.add('active');
    }
  
    function adjustCarouselItems(carouselElement) {
      const itemCount = findElements(carouselElement, '.carousel-item').length;
      const visibleItems = carouselElement.querySelector('.carousel-inner').getAttribute('data-visible');
      const actualVisible = Math.min(itemCount, visibleItems || itemCount);
  
      carouselElement.querySelector('.carousel-inner').classList.add(`slides${actualVisible}`);
  
      findElements(carouselElement, '.clonedCol').forEach(clone => clone.remove());
  
      findElements(carouselElement, '.carousel-item .col-md-12').forEach(col => {
        if (actualVisible > 2) {
          col.classList.add('col-lg-15');
        } else if (actualVisible === 5) {
          col.classList.add('col-md-12', 'col-lg-15');
        } else {
          col.classList.add(`col-md-12`, `col-lg-${12 / actualVisible}`);
        }
      });
  
      findElements(carouselElement, '.carousel-item .row').forEach(row => {
        row.style.flexBasis = 'auto';
        row.style.flexGrow = 1;
        row.style.margin = '0';
      });
  
      findElements(carouselElement, '.carousel-item').forEach((item, index) => {
        for (let i = 1; i < actualVisible; i++) {
          const nextItem = item.nextElementSibling || carouselElement.querySelector('.carousel-item');
          if (nextItem) {
            const clonedItem = item.querySelector('.col-md-12').cloneNode(true);
            clonedItem.classList.add(`cloneditem-${i}`);
            clonedItem.classList.add('clonedCol');
            clonedItem.dataset.clonedIndex = nextItem.dataset.clonedIndex || -1;
            item.children[0].appendChild(clonedItem);
          }
        }
      });
    }
  
    function extractSvgGradient(svgElement) {
        const gradient = svgElement.querySelector('svg linearGradient');
        if (!gradient) return '';
      
        const colors = Array.from(gradient.children).map(stop => `"${stop.getAttribute('stop-color')}"`);
        return `{
          "linearGradient": [${colors}]
        }`;
      } })
      