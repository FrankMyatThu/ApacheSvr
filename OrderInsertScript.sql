SELECT * FROM products;
SELECT * FROM orders;
SELECT * FROM orderdetails;

-- ---------------------------------------------------------------------------------------------------------------------------------------------------------
-- Insert
-- ---------------------------------------------------------------------------------------------------------------------------------------------------------

INSERT INTO orders (Description, OrderDate) VALUES ('Order One', '2016/04/07')
INSERT INTO orderdetails (OrderId, ProductID, Quantity, Total, TotalGST) VALUES (2, 1, 10, 32470.00, 2272.90);
INSERT INTO orderdetails (OrderId, ProductID, Quantity, Total, TotalGST) VALUES (2, 2, 10, 35600.00, 2492.00);
INSERT INTO orderdetails (OrderId, ProductID, Quantity, Total, TotalGST) VALUES (2, 3, 15, 106500.00, 7455.00);


INSERT INTO orders (Description, OrderDate) VALUES ('Order Two', '2016/04/07')
INSERT INTO orderdetails (OrderId, ProductID, Quantity, Total, TotalGST) VALUES (3, 4, 5, 34745.00, 2432.15);
INSERT INTO orderdetails (OrderId, ProductID, Quantity, Total, TotalGST) VALUES (3, 2, 10, 35600.00, 2492.00);
INSERT INTO orderdetails (OrderId, ProductID, Quantity, Total, TotalGST) VALUES (3, 3, 15, 106500.00, 7455.00);

SELECT 6949.00 * 5
SELECT 34745.00 * 0.07

-- ---------------------------------------------------------------------------------------------------------------------------------------------------------
-- Select
-- ---------------------------------------------------------------------------------------------------------------------------------------------------------
SELECT * FROM Orders
INNER JOIN OrderDetails ON Orders.OrderID = OrderDetails.OrderID
INNER JOIN Products ON OrderDetails.ProductID = Products.ProductID

-- Get Order Lising
SELECT OrderId, Description, OrderDate FROM Orders WHERE 1=1

-- Get Order Master Detail
-- Get Master
SELECT OrderId, Description, OrderDate FROM Orders WHERE 1=1;
-- Get Detail
SELECT OrderDetailID, OrderId, OrderDetails.ProductID, ProductName, Quantity, Total, TotalGST FROM OrderDetails
INNER JOIN Products ON OrderDetails.ProductID = Products.ProductID 
WHERE OrderDetails.OrderId = 2;


SELECT @row := @row + 1 AS SrNo, `OrderID`, `Description`, `OrderDate` FROM Orders, (SELECT @row := 0) RowCounter WHERE `OrderID` = 2 ORDER BY `OrderID` DESC, `Description` DESC LIMIT 100 OFFSET 0  
