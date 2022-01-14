BEGIN;
CREATE DATABASE `e-commerce`;
USE `e-commerce`;

CREATE TABLE `User` (
    `UserID` INT  NOT NULL AUTO_INCREMENT,
    `Username` varchar(30)  NOT NULL ,
    `PasswordHash` varchar(255)  NOT NULL ,
    `Email` varchar(320)  NOT NULL ,
    `Enable` boolean NOT NULL DEFAULT True ,
    PRIMARY KEY (
        `UserID`
    ),
    CONSTRAINT `uc_User_Username` UNIQUE (
        `Username`
    )
);

CREATE TABLE `Client` (
    `UserID` INT  NOT NULL ,
    `CartID` INT ,
    PRIMARY KEY (
        `UserID`
    )
);

CREATE TABLE `Vendor` (
    `UserID` INT  NOT NULL ,
    PRIMARY KEY (
        `UserID`
    )
);

CREATE TABLE `Order` (
    `OrderID` INT  NOT NULL AUTO_INCREMENT,
    `Time` datetime  NOT NULL DEFAULT CURRENT_TIMESTAMP,
    `CartID` INT  NOT NULL ,
    `OrderStatusID` ENUM('AtStorage','Departed','Delivered','Collected')  NOT NULL DEFAULT 'AtStorage',
    PRIMARY KEY (
        `OrderID`
    )

    CONSTRAINT `uc_Order_CartID` UNIQUE (
        `CartID`
    )
);

CREATE TABLE `Product` (
    `ProductID` INT  NOT NULL AUTO_INCREMENT,
    `Name` varchar(50)  NOT NULL ,
    `Image` varchar(200) NOT NULL DEFAULT 'noimage.png' ,
    `Description` text  NOT NULL DEFAULT 'No description',
    `Quantity` INT  NOT NULL ,
    `Price` INT UNSIGNED  NOT NULL ,
    `VendorID` INT  NOT NULL ,
    `CategoryID` INT  NOT NULL ,
    PRIMARY KEY (
        `ProductID`
    ),
    CONSTRAINT `uc_Product_Name` UNIQUE (
        `Name`
    )
);

CREATE TABLE `Category` (
    `CategoryID` INT  NOT NULL AUTO_INCREMENT,
    `Name` varchar(30)  NOT NULL ,
    PRIMARY KEY (
        `CategoryID`
    ),
    CONSTRAINT `uc_Category_Name` UNIQUE (
        `Name`
    )
);

CREATE TABLE `Cart` (
    `ClientID` INT  NOT NULL ,
    `CartID` INT  NOT NULL AUTO_INCREMENT,
    PRIMARY KEY (
        `CartID`
    )
);

CREATE TABLE `CartItem` (
    `CartItemID` INT  NOT NULL AUTO_INCREMENT,
    `CartID` INT  NOT NULL ,
    `ProductID` INT  NOT NULL ,
    `Quantity` INT UNSIGNED NOT NULL ,
    PRIMARY KEY (
        `CartItemID`
    )
);

CREATE TABLE `Notification` (
    `NotificationID` INT  NOT NULL AUTO_INCREMENT,
    `UserID` INT  NOT NULL ,
    `Text` text  NOT NULL ,
    PRIMARY KEY (
        `NotificationID`
    )
);

ALTER TABLE `Client` ADD CONSTRAINT `fk_Client_UserID` FOREIGN KEY(`UserID`)
REFERENCES `User` (`UserID`)
ON DELETE CASCADE
ON UPDATE CASCADE;


ALTER TABLE `Client` ADD CONSTRAINT `fk_Client_CartID` FOREIGN KEY(`CartID`)
REFERENCES `Cart` (`CartID`)
ON DELETE SET NULL
ON UPDATE CASCADE;

ALTER TABLE `Cart` ADD CONSTRAINT `fk_Cart_ClientID` FOREIGN KEY(`ClientID`)
REFERENCES `Client` (`UserID`)
ON DELETE SET NULL
ON UPDATE CASCADE;


ALTER TABLE `Vendor` ADD CONSTRAINT `fk_Vendor_UserID` FOREIGN KEY(`UserID`)
REFERENCES `User` (`UserID`)
ON DELETE NO ACTION
ON UPDATE CASCADE;

ALTER TABLE `Order` ADD CONSTRAINT `fk_Order_CartID` FOREIGN KEY(`CartID`)
REFERENCES `Cart` (`CartID`)
ON UPDATE CASCADE;

ALTER TABLE `Product` ADD CONSTRAINT `fk_Product_VendorID` FOREIGN KEY(`VendorID`)
REFERENCES `Vendor` (`UserID`)
ON DELETE NO ACTION
ON UPDATE CASCADE;

ALTER TABLE `Product` ADD CONSTRAINT `fk_Product_CategoryID` FOREIGN KEY(`CategoryID`)
REFERENCES `Category` (`CategoryID`)
ON DELETE SET NULL
ON UPDATE CASCADE;

ALTER TABLE `CartItem` ADD CONSTRAINT `fk_CartItem_CartID` FOREIGN KEY(`CartID`)
REFERENCES `Cart` (`CartID`)
ON DELETE CASCADE
ON UPDATE CASCADE;

ALTER TABLE `CartItem` ADD CONSTRAINT `fk_CartItem_ProductID` FOREIGN KEY(`ProductID`)
REFERENCES `Product` (`ProductID`)
ON DELETE RESTRICT
ON UPDATE CASCADE;

ALTER TABLE `Notification` ADD CONSTRAINT `fk_Notification_UserID` FOREIGN KEY(`UserID`)
REFERENCES `User` (`UserID`)
ON DELETE CASCADE
ON UPDATE CASCADE;

END;
COMMIT;