CREATE TABLE Products
(
	ProductID INT AUTO_INCREMENT NOT NULL,	
	ProductName NVARCHAR(250),
	Description NVARCHAR(250),
	ProductImage NVARCHAR(250),
	Price DECIMAL(10,2),
	Active BIT,
	PRIMARY KEY (ProductID)
);

CREATE TABLE Orders
(
	OrderId INT AUTO_INCREMENT NOT NULL,
	Description NVARCHAR(250),
	OrderDate DATETIME,
	PRIMARY KEY (OrderId)
);

CREATE TABLE OrderDetails
(
	OrderDetailId INT AUTO_INCREMENT NOT NULL,
	OrderId INT,
	ProductID INT,
	Quantity INT,
	Total DECIMAL(10,2),
	TotalGST DECIMAL(10,2),
	
	PRIMARY KEY(OrderDetailId),

	FOREIGN KEY(OrderId) REFERENCES Orders(OrderId)
	ON DELETE NO ACTION
	ON UPDATE NO ACTION,

	FOREIGN KEY(ProductID) REFERENCES Products(ProductID)
	ON DELETE NO ACTION
	ON UPDATE NO ACTION
);