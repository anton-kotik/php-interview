
A courier on a motorcycle is delivering packages. There are several delivery orders: A, B, C, etc.
Each order consists of two points (addresses). For each order, the courier should pick up the parcel
at the first address (B1) and deliver it to the second address (B2).

![](image.png)

The route time in minutes between all points and the courier is specified in the file.
For example, for [data2.txt](data/data2.txt) file, the travel time from the courier (CR)
to point B1 is 14 minutes, and from point B2 to the courier (CR) is 53 minutes.

```
   CR A1 A2 B1 B2 C1 C2
CR  0 97 36 14 52 59 89
A1 94  0 68 14 63 25 30
A2 38 65  0 20 20 56 82
B1 13 14 20  0 56  4 99
B2 53 58 21 58  0 17 85
C1 61 27 57  4 16  0 84
C2 89 31 79 99 90 78  0
```

Solve the problems below. Feel free to use Google, StackOverflow, and PHP documentation if needed.

### Problem 1
Find the nearest order to the courier. Modify the script `problem1.php` so that it returns<br>
the name of the point (for example, `B1`) to which the courier should go to get his first parcel as soon as possible.

```shell
php problem1.php data1.txt
```

<details>
<summary>Check your solution.</summary>

| Data file     | Command                      | Expected result |
|---------------|------------------------------|-----------------|
| **data1.txt** | `php problem1.php data1.txt` | `A1`            |
| **data2.txt** | `php problem1.php data2.txt` | `B1`            |
| **data3.txt** | `php problem1.php data3.txt` | `C1`            |

</details>

### Problem 2
Find the most optimal route to deliver all orders in minimum time.<br>
The courier can carry maximum 2 parcels at the same time.

```shell
php problem2.php data1.txt
```

Modify the `problem2.php` script so that it returns the route points on the first line<br>
and the total route time on the second line. For example:
```
A1 B1 B2 A2
175
```

<details>
<summary>Check your solution.</summary>

| Data file     | Command                      | Expected result                            |
|---------------|------------------------------|--------------------------------------------|
| **data1.txt** | `php problem2.php data1.txt` | Route: `A1 B1 B2 A2`      <br/>Time: `175` |
| **data2.txt** | `php problem2.php data2.txt` | Route: `B1 C1 B2 A1 C2 A2`<br/>Time: `201` |
| **data3.txt** | `php problem2.php data3.txt` | Route: `C1 C2 A1 A2 B1 B2`<br/>Time: `95`  |

If you wish, optimize the code and test your solution on files with large number of orders:

| Data file     | Command                      | Expected result                                                          |
|---------------|------------------------------|--------------------------------------------------------------------------|
| **huge1.txt** | `php problem2.php huge1.txt` | Route: `F1 F2 D1 E1 E2 D2 C1 B1 C2 A1 B2 A2`            <br/>Time: `314` |
| **huge2.txt** | `php problem2.php huge2.txt` | Route: `C1 B1 C2 G1 B2 E1 G2 F1 E2 F2 D1 H1 H2 A1 A2 D2`<br/>Time: `340` |

</details>
