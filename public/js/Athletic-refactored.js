/**
 * Athletic Trainer - Refactored JavaScript
 * Modern ES6+ implementation with better structure
 */

// Diagnostic Module
const DiagnosticModule = {
    /**
     * Initialize diagnostic functionality
     */
    init() {
        const submitBtn = document.querySelector('#bodyPart button[type="button"]');
        if (submitBtn) {
            submitBtn.addEventListener('click', this.checkSelected.bind(this));
        }
    },

    /**
     * Check which body part is selected
     */
    checkSelected() {
        const parts = {
            'part1': 'Elbow',
            'part2': 'Ankle',
            'part3': 'Groin',
            'part4': 'Thighs',
            'part5': 'Knee'
        };

        for (const [id, name] of Object.entries(parts)) {
            const radio = document.getElementById(id);
            if (radio && radio.checked) {
                this.showQuestions(name);
                return;
            }
        }
    },

    /**
     * Show questions for selected body part
     */
    showQuestions(bodyPart) {
        const handlers = {
            'Elbow': this.showElbowQuestions,
            'Ankle': this.showAnkleQuestions,
            'Groin': this.showGroinQuestions,
            'Thighs': this.showThighQuestions,
            'Knee': this.showKneeQuestions
        };

        const handler = handlers[bodyPart];
        if (handler) {
            handler.call(this);
        }
    },

    /**
     * Show elbow diagnostic questions
     */
    showElbowQuestions() {
        $('#myElbowModal1').modal('show');
        
        $('#elbowQ1y').off('click').on('click', () => {
            $('#myElbowModal2').modal('show');
            
            $('#elbowQ2y').off('click').on('click', () => {
                this.showConfirmation('elbow', '../view/diagnostic.php#elbowInfo');
            });
            
            $('#elbowQ2n').off('click').on('click', () => {
                this.showOkMessage();
            });
        });
        
        $('#elbowQ1n').off('click').on('click', () => {
            $('#myElbowModal2').modal('show');
            
            $('#elbowQ2y, #elbowQ2n').off('click').on('click', () => {
                this.showIncompleteMessage();
            });
        });
    },

    /**
     * Show ankle diagnostic questions
     */
    showAnkleQuestions() {
        $('#myAnkleModal1').modal('show');
        
        $('#ankleQ1y').off('click').on('click', () => {
            $('#myAnkleModal2').modal('show');
            
            $('#ankleQ2y').off('click').on('click', () => {
                $('#myAnkleModal3').modal('show');
                
                $('#ankleQ3y').off('click').on('click', () => {
                    this.showSprainConfirmation('../view/diagnostic.php#ankleInfo');
                });
                
                $('#ankleQ3n').off('click').on('click', () => {
                    this.showOkMessage();
                });
            });
            
            $('#ankleQ2n').off('click').on('click', () => {
                this.showOkMessage();
            });
        });
        
        $('#ankleQ1n').off('click').on('click', () => {
            $('#myAnkleModal2').modal('show');
            
            $('#ankleQ2y, #ankleQ2n').off('click').on('click', () => {
                this.showIncompleteMessage();
            });
        });
    },

    /**
     * Show groin diagnostic questions
     */
    showGroinQuestions() {
        $('#myGroinModal1').modal('show');
        
        $('#groinQ1y').off('click').on('click', () => {
            $('#myGroinModal2').modal('show');
            
            $('#groinQ2y').off('click').on('click', () => {
                this.showGroinConfirmation('../view/diagnostic.php#groinInfo');
            });
            
            $('#groinQ2n').off('click').on('click', () => {
                this.showOkMessage();
            });
        });
        
        $('#groinQ1n').off('click').on('click', () => {
            $('#myGroinModal2').modal('show');
            
            $('#groinQ2y, #groinQ2n').off('click').on('click', () => {
                this.showIncompleteMessage();
            });
        });
    },

    /**
     * Show thigh diagnostic questions
     */
    showThighQuestions() {
        $('#myThighModal1').modal('show');
        
        $('#thighQ1y').off('click').on('click', () => {
            $('#myThighModal2').modal('show');
            
            $('#thighQ2y').off('click').on('click', () => {
                $('#myThighModal3').modal('show');
                
                $('#thighQ3y').off('click').on('click', () => {
                    this.showHamstringConfirmation('../view/diagnostic.php#thighsInfo');
                });
                
                $('#thighQ3n').off('click').on('click', () => {
                    this.showOkMessage();
                });
            });
            
            $('#thighQ2n').off('click').on('click', () => {
                this.showIncompleteMessage();
            });
        });
        
        $('#thighQ1n').off('click').on('click', () => {
            $('#myThighModal2').modal('show');
            
            $('#thighQ2y, #thighQ2n').off('click').on('click', () => {
                this.showIncompleteMessage();
            });
        });
    },

    /**
     * Show knee diagnostic questions
     */
    showKneeQuestions() {
        $('#myKneeModal1').modal('show');
        
        $('#kneeQ1y').off('click').on('click', () => {
            $('#myKneeModal2').modal('show');
            
            $('#kneeQ2y').off('click').on('click', () => {
                $('#myKneeModal3').modal('show');
                
                $('#kneeQ3y').off('click').on('click', () => {
                    this.showKneeConfirmation('../view/diagnostic.php#kneeInfo');
                });
                
                $('#kneeQ3n').off('click').on('click', () => {
                    this.showOkMessage();
                });
            });
            
            $('#kneeQ2n').off('click').on('click', () => {
                this.showIncompleteMessage();
            });
        });
        
        $('#kneeQ1n').off('click').on('click', () => {
            $('#myKneeModal2').modal('show');
            
            $('#kneeQ2y, #kneeQ2n').off('click').on('click', () => {
                this.showIncompleteMessage();
            });
        });
    },

    /**
     * Show confirmation modal
     */
    showConfirmation(type, url) {
        $('#elbowConfirm').modal('show');
        $('#elbowGo').off('click').on('click', () => {
            window.location.href = url;
        });
    },

    /**
     * Show sprain confirmation
     */
    showSprainConfirmation(url) {
        $('#sprainConfirm').modal('show');
        $('#strainGo').off('click').on('click', () => {
            window.location.href = url;
        });
    },

    /**
     * Show groin confirmation
     */
    showGroinConfirmation(url) {
        $('#groinConfirm').modal('show');
        $('#groinGo').off('click').on('click', () => {
            window.location.href = url;
        });
    },

    /**
     * Show hamstring confirmation
     */
    showHamstringConfirmation(url) {
        $('#harmstringConfirm').modal('show');
        $('#harmStringGo').off('click').on('click', () => {
            window.location.href = url;
        });
    },

    /**
     * Show knee confirmation
     */
    showKneeConfirmation(url) {
        $('#kneeConfirm').modal('show');
        $('#kneeGo').off('click').on('click', () => {
            window.location.href = url;
        });
    },

    /**
     * Show OK message
     */
    showOkMessage() {
        $('#okConfirm').modal('show');
    },

    /**
     * Show incomplete message
     */
    showIncompleteMessage() {
        $('#incomplete').modal('show');
    }
};

// Contact Form Module
const ContactModule = {
    /**
     * Initialize contact form
     */
    init() {
        const contactBtn = document.getElementById('Contact');
        const resetBtn = document.getElementById('reset');
        
        if (contactBtn) {
            contactBtn.addEventListener('click', this.sendMessage.bind(this));
        }
        
        if (resetBtn) {
            resetBtn.addEventListener('click', this.reset.bind(this));
        }
    },

    /**
     * Send message
     */
    sendMessage() {
        const firstName = document.getElementById('firstName');
        const lastName = document.getElementById('lastName');
        const email = document.getElementById('eMail');
        const comment = document.getElementById('commentText');

        if (!firstName.value || !lastName.value || !email.value) {
            alert('Please fill in all required fields.');
            return;
        }

        // In a real implementation, this would send via AJAX
        alert('Your message was successfully sent!');
        this.reset();
    },

    /**
     * Reset form
     */
    reset() {
        const fields = ['firstName', 'lastName', 'eMail', 'commentText'];
        fields.forEach(id => {
            const field = document.getElementById(id);
            if (field) field.value = '';
        });
    }
};

// Image Carousel Module
const ImageCarouselModule = {
    dishes: [
        'uniqueRunner1.jpg',
        'uniqueRunner2.jpg',
        'uniqueRunner3.jpg',
        'uniqueRunner4.jpg',
        'uniqueRunner5.jpg',
        'uniqueRunner6.jpg'
    ],
    currentIndex: 0,
    intervalId: null,

    /**
     * Initialize image carousel
     */
    init() {
        const menuImage = document.getElementById('menuImage');
        if (menuImage) {
            this.startCarousel();
        }
    },

    /**
     * Start carousel
     */
    startCarousel() {
        this.intervalId = setInterval(() => {
            this.displayNextImage();
        }, 3000);
    },

    /**
     * Display next image
     */
    displayNextImage() {
        const menuImage = document.getElementById('menuImage');
        if (!menuImage) {
            this.stopCarousel();
            return;
        }

        this.currentIndex = (this.currentIndex + 1) % this.dishes.length;
        menuImage.src = `../images/${this.dishes[this.currentIndex]}`;
    },

    /**
     * Stop carousel
     */
    stopCarousel() {
        if (this.intervalId) {
            clearInterval(this.intervalId);
        }
    }
};

// Initialize all modules when DOM is ready
document.addEventListener('DOMContentLoaded', () => {
    DiagnosticModule.init();
    ContactModule.init();
    ImageCarouselModule.init();
});

// Legacy function for backward compatibility
function checkSelected() {
    DiagnosticModule.checkSelected();
}

function sendMessage() {
    ContactModule.sendMessage();
}

function reset() {
    ContactModule.reset();
}
