<?php 

    class ClassSwitch 
    {

        public function CarBrandSwitch($Data)
        {
            switch ($Data) {
                case 1:
                return "Ford";
                break;
                case 2:
                return "Range Rover";
                break;
                case 3:
                return "Porsche";
                break;
                case 4:
                return "Nissan";
                break;
                case 5:
                return "BMW";
                break;
                case 6:
                return "Citreon";
                break;
                case 7:
                return "Opel";
                break;
                case 8:
                return "Toyota";
                break;
            }
        } 

        public function CarColorSwitch($Data)
        {
            switch ($Data) 
            {
                case 1:
                return "Black";
                break;
                case 2:
                return "Red";
                break;
                case 3:
                return "Grey";
                break;
                case 4:
                return "Blue";
                break;
            }
        } 

        
}


