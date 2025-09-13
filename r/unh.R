rm(list=ls(all=TRUE))
library(ggplot2)
library(reshape)



working.dir <- "/home/mbc/projects/unhwatch/"
file.prefix <- "demo"


file.name<- paste( working.dir, file.prefix, ".csv", sep="")
d <- read.table (file = file.name,  sep = ",", dec = ".",   header=TRUE, skip = 0, na.strings = "NA", strip.white = TRUE )

d$Annual.Base.Pay <- as.numeric(gsub('[$,]', '', d$Annual.Base.Pay))
d2 <- as.data.frame(tapply(d$Annual.Base.Pay, d$Job.Title, median))
d2$title <- rownames(d2)
colnames(d2) <- c("median.salary", "title")
rownames(d2) <- NULL
d2 <- d2[order(d2$median.salary, decreasing=TRUE),]

##remove low salary support staff < $50K per year
d3 <- d2[d2$median.salary>50000,]
nrow(d3) ## 595
##use those titles to select from the main dataset
d4 <- d[d$Job.Title %in% d3$title,]
nrow(d4) ## 3320  d is 4133

d4UNH <- d4[d4$campus=="UNH",]
nrow(d4UNH) ##2620

d4UNH <- d4UNH[,2:5]
names(d4UNH) <- c( "name","title","FTE","salary")

##write out and get departments

write.table(d4UNH, file = "d4UNH.txt", append = FALSE, quote = FALSE, sep = "\t",
            eol = "\n", na = "NA", dec = ".", row.names = FALSE,
            col.names = TRUE, fileEncoding = "")


#################php makes d5UHN by adding dept

file.prefix <- "demo"


file.name<- paste( working.dir, file.prefix, ".csv", sep="")
d <- read.table (file = file.name,  sep = ",", dec = ".",   header=TRUE, skip = 0, na.strings = "NA", strip.white = TRUE )























d2 <- cbind( d[,1:2], rowMeans(d[,3:5]),  rowMeans(d[,6:8]),  rowMeans(d[,9:11]), rowMeans(d[,12:14]),  rowMeans(d[,15:17]))

names(d2) <- c("index", "date", "SB", "DB", "BP", "SA", "DA")

days <- as.numeric(as.Date(d2$date))

d3 <- cbind(d2, days)

d4 <- reshape(d3, timevar="index", v.names="yval", varying=c( "SB", "DB", "BP", "SA", "DA"), times=c( "SB", "DB", "BP", "SA", "DA"),  direction="long")




p <- ggplot(d4, aes(days, yval)) + geom_point(aes(colour=factor(index)), size=3)  + scale_y_continuous(limits = c(10, 160)) + ylab("") + scale_x_continuous(breaks=d3$days,labels=d3$date) + theme(axis.text.x=element_text(angle=90)) + xlab("Date") 

xval <- as.numeric(as.Date("2023-08-15"))

p <- p + geom_text(x=xval, y=30, label="Covid+") + geom_segment(aes(x = xval, y = 26, xend = xval, yend = 10),
                  arrow = arrow(length = unit(0.2, "cm")))

xval <- as.numeric(as.Date("2023-09-13"))

p + geom_text(x=xval, y=30, label="lisinopril 2.5-> 0mg") + geom_segment(aes(x = xval, y = 26, xend = xval, yend = 10),
                  arrow = arrow(length = unit(0.2, "cm")))
