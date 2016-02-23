<?php 
	
	/*
	 *  ACCOUNT HEAD CONSTANTS
	 */
	
	define("GET_ALL_ACCOUNTHEADS","select * from accounthead");
	define("GET_ACCOUNTHEADS_BY_CHANNEL","select * from accounthead where parent_channel_id=?");
	define("GET_ACCOUNTHEAD_BY_NAME","select * from accounthead where UPPER(acchead_name)=UPPER(?)");
	define("ADD_ACCOUNTHEAD_INFO","insert into accounthead values (null,?,?)");
	define("MODIFY_ACCOUNTHEAD_INFO","update accounthead set acchead_name=? where acchead_id=?");
	define("DELETE_ACCOUNTHEAD_INFO","delete from accounthead where acchead_id=?");
	define("DOES_ACCOUNTHEAD_EXISTS","select * from accounthead where UPPER(acchead_name)=UPPER(?) and parent_channel_id=?");
	
	/* 
	 * CHANNEL CONSTANTS
	 */
	
	define("GET_ALL_CHANNELS","select * from channel");
	define("GET_CHANNELS_BY_TYPE","select * from channel where channel_type=?");
	define("GET_CHANNEL_INFO","select * from channel where channel_id=?");
	define("ADD_CHANNEL_INFO","insert into channel values (null,?,?)");
	define("MODIFY_CHANNEL_INFO","update channel set channel_name=? where channel_id=?");
	define("DELETE_CHANNEL_INFO","delete from channel where channel_id=?");
	define("DOES_CHANNEL_EXISTS","select * from channel where UPPER(channel_name)=UPPER(?) and channel_type=?");
	
	/*
	 * ITEM CONSTANTS
	 */
	
	define("GET_ALL_ITEMS","select * from item");
	define("GET_ITEMS_BY_GROUP","select * from item where parent_group_id=?");
	define("GET_ITEM_INFO","select * from item where item_id=?");
	define("ADD_ITEM_INFO","insert into item values (null,?,?)");
	define("MODIFY_ITEM_INFO","update item set item_name=? where item_id=?");
	define("DELETE_ITEM_INFO","delete from item where item_id=?");
	define("DOES_ITEM_EXISTS","select * from item where UPPER(item_name)=UPPER(?) and parent_group_id=?");
	
	/*
	 * ITEM GROUP CONSTANTS
	 */
	
	
	define("GET_ALL_ITEMGROUPS","select * from itemgroup order by group_name");
	define("GET_ITEMGROUP_INFO","select * from itemgroup where group_id=?");
	define("ADD_ITEMGROUP_INFO","insert into itemgroup values (null,?)");
	define("MODIFY_ITEMGROUP_INFO","update itemgroup set group_name=? where group_id=?");
	define("DELETE_ITEMGROUP_INFO","delete from itemgroup where group_id=?");
	define("DOES_GROUP_EXISTS","select * from itemgroup where UPPER(group_name)=UPPER(?)");
	
	/*
	 * SUBITEM CONSTANTS
	 */
	
	
	define("GET_ALL_SUBITEMS","select * from subitem");
	define("GET_SUBITEMS_BY_ITEM","select * from subitem where parent_item_id=?");
	define("GET_SUBITEM_INFO","select * from subitem where subitem_id=?");
	define("ADD_SUBITEM_INFO","insert into subitem values (null,?,?)");
	define("MODIFY_SUBITEM_INFO","update subitem set subitem_name=? where subitem_id=?");
	define("DELETE_SUBITEM_INFO","delete from subitem where subitem_id=?");
	define("DOES_SUBITEM_EXISTS","select * from subitem where UPPER(subitem_name)=UPPER(?) and parent_item_id=?");
	
	/*
	 * SUPPLIER CONSTANTS
	 */
	
	define("GET_ALL_SUPPLIERS","select * from supplier order by supplier_name");
	define("GET_SUPPLIER_INFO","select * from supplier where supplier_id=?");
	define("ADD_SUPPLIER_INFO","insert into supplier values (null,?,?,?,?,?,?,?,?,?)");
	define("MODIFY_SUPPLIER_INFO","update supplier set supplier_name=?,op_pg=?,op_lpg=?,op_silver=?,op_cash=?,cl_pg=?,cl_lpg=?,cl_silver=?,cl_cash=? where supplier_id=?");
	define("DELETE_SUPPLIER_INFO","delete from supplier where supplier_id=?");
	define("DOES_SUPPLIER_EXISTS","select * from supplier where UPPER(supplier_name)=UPPER(?)");
	define("DOES_OTHER_SUPPLIER_EXISTS","select * from supplier where UPPER(supplier_name)=UPPER(?) and supplier_id <> ?");
	
	/*
	 * USER CONSTANTS
	 */
	
	define("GET_USER_INFO","select * from user where username=? and password=? and usertype=?");
	define("ADD_USER_INFO","insert into user values (?,?,?,?)");
	define("MODIFY_USER_INFO","update user set (user_id=?,username=?,password=?,usertype=?)");
	define("DELETE_USER_INFO","delete from user where id=?");
	
	/*
	 * RATE CONSTANTS
	 */
	
	define("GET_ALL_RATES","select * from rate");
	define("GET_RATE_INFO","select * from rate where rate_id=?");
	define("GET_RATE_BY_TYPE","select * from rate where metal=?");
	define("ADD_RATE_INFO","insert into rate values (null,?,?)");
	define("MODIFY_RATE_INFO","update rate set rate=? where metal=?");
	
	/*
	 * COMPANY CONSTANTS
	 */
	define("GET_COMPANY_INFO","select * from company where id=?");
	define("ADD_COMPANY_INFO","insert into company values (?,?,?,?,?,?,?,?,?)");
	define("MODIFY_COMPANY_INFO","update company set op_pg=?,op_lpg=?,op_silver=?,op_cash=?,cl_pg=?,cl_lpg=?,cl_silver=?,cl_cash=? where id=?");
	define("DELETE_COMPANY_INFO","delete from company where id=?");
	
	/*
	 * EMPLOYEE CONSTANTS 
	 */
	
	define("GET_ALL_EMPLOYEES","select * from employee");
	define("GET_EMPLOYEE_INFO","select * from employee where employee_id=?");
	define("ADD_EMPLOYEE_INFO","insert into employee values (null,?)");
	define("MODIFY_EMPLOYEE_INFO","update employee set (employee_id=?,employee_name=?)");
	define("DELETE_EMPLOYEE_INFO","delete from employee where id=?");
	define("DOES_EMPLOYEE_EXISTS","select * from employee where UPPER(employee_name)=UPPER(?)");
	define("DOES_OTHER_EMPLOYEE_EXISTS","select * from employee where UPPER(employee_name)=UPPER(?) and employee_id <> ?");
	
	/*
	 * LOCATION CONSTANTS 
	 */
	
	define("GET_ALL_LOCATIONS","select * from location");
	define("GET_LOCATION_INFO","select * from location where location_id=?");
	define("ADD_LOCATION_INFO","insert into location values (null,?)");
	define("MODIFY_LOCATION_INFO","update location set (location_id=?,location_name=?)");
	define("DELETE_LOCATION_INFO","delete from location where id=?");
	define("DOES_LOCATION_EXISTS","select * from location where UPPER(location_name)=UPPER(?)");
	define("DOES_OTHER_LOCATION_EXISTS","select * from location where UPPER(location_name)=UPPER(?) and location_id <> ?");
	
	/*
	 * DAYBOOK CONSTANTS
	 */
	
	define("GET_TODAYS_ACCOUNTS","select * from daybook where date=date(now())");
	define("GET_ACCOUNTS_BY_DATE","select * from daybook where date=?");
	define("GET_INCOMING_BY_DATE","select txn_id,date,type,category_id,acchead_id, sum(pg),sum(lpg),sum(silver),sum(cash),description from daybook where type='incoming' and date=? group by acchead_id");
	define("GET_DETAILED_INCOMING_BY_DATE","select *  from daybook where type='incoming' and date=?");
	define("GET_OUTGOING_BY_DATE","select txn_id,date,type,category_id,acchead_id, sum(pg),sum(lpg),sum(silver),sum(cash),description from daybook where type='outgoing' and date=? group by acchead_id");
	define("GET_DETAILED_OUTGOING_BY_DATE","select * from daybook where type='outgoing' and date=?");
	define("GET_INCOMING_BY_DATE_RANGE","select sum(pg),sum(lpg),sum(silver),sum(cash)  from daybook where type='incoming' and date>=? and date<?");
	define("GET_OUTGOING_BY_DATE_RANGE","select sum(pg),sum(lpg),sum(silver),sum(cash)  from daybook where type='outgoing' and date>=? and date<?");
	define("GET_ACCOUNTS_BY_ID","select * from daybook where txn_id=?");
	define("GET_ACCOUNTS_BY_ACCHEADID","select * from daybook where acchead_id=?");
	define("ADD_DAYBOOK_INFO","insert into daybook values (null,?,?,?,?,?,?,?,?,?)");
	define("MODIFY_DAYBOOK_INFO","update daybook set date=?,category_id=?,acchead_id=?,pg=?,lpg=?,silver=?,cash=?,description=? where txn_id=?");
	define("DELETE_DAYBOOK_INFO","delete from daybook where txn_id=?");
	
	/*
	 * PAYMENT CONSTANTS
	 */
	
	define("GET_PAYMENT_INFO","select * from payment");
	define("GET_PAYMENT_BY_ID","select * from payment where txn_id=?");
	define("GET_PAYMENTS_BY_DATE_RANGE","select sum(amount),payment_mode from payment where date>=? and date<? group by payment_mode");
	define("GET_SUPPLIER_PAYMENTS_BY_DATE_RANGE","select sum(adjust_amount),adjust_with from payment where supplier_id=? and date>=? and date<? group by adjust_with");
	define("GET_PAYMENT_DETAILS_BY_DATE_RANGE","select * from payment where supplier_id=? and date>=? and date<=? order by date");
	define("GET_DAYWISE_PAYMENTS","select * from payment where date=?");
	define("GET_CURRENT_PAYMENT_AMOUNT","select amount from payment where txn_id=?");
	define("GET_CURRENT_ADJUSTED_AMOUNT","select adjust_amount from payment where txn_id=?");
	define("ADD_PAYMENT_INFO","insert into payment values (null,?,?,?,?,?,?,?,?)");
	define("MODIFY_PAYMENT_INFO","update payment set date=?,supplier_id=?,voucher_no=?,payment_mode=?,amount=?,adjust_with=?,adjust_amount=?,description=? where txn_id=?");
	define("DELETE_PAYMENT_INFO","delete from payment where txn_id=?");
	define("DOES_VOUCHERNO_EXISTS","select * from payment where supplier_id=? and voucher_no=?");
	define("DOES_OTHER_VOUCHERNO_EXISTS","select * from payment where txn_id <> ? and supplier_id=? and voucher_no=?");
	
	/*
	 * TRANSFER CONSTANTS
	 */
	
	define("GET_ALL_TRANSFERS","select * from transfer");
	define("GET_TRANSFERS_BY_DATE","select * from transfer where date=?");
	define("GET_TRANSFER_BY_ID","select * from transfer where txn_id=?");
	define("ADD_TRANSFER_INFO","insert into transfer values (null,?,?,?,?,?,?,?)");
	define("DELETE_TRANSFER_INFO","delete from transfer where txn_id=?");
	
	/*
	 * Purchase Details Constants
	 */
	
	define("GET_CURRENT_PURCHASE_MC_VALUES_BY_DATE_RANGE","select p.date,pd.maintain_mc_value,pd.maintain_mc_as,pd.payment_days from purchase p,purchasedetails pd where p.supplier_id=? and pd.last_payment_date>? and p.date<=? and pd.txn_id=p.txn_id");
	define("GET_CURRENT_PURCHASE_MC_VALUES_BY_DATE","select p.date,pd.maintain_mc_value,pd.maintain_mc_as,pd.payment_days from purchase p,purchasedetails pd where p.supplier_id=? and pd.last_payment_date>=? and pd.txn_id=p.txn_id");
	define("GET_CURRENT_PURCHASE_METAL_VALUES_BY_DATE_RANGE","select p.date, pd.maintain_metal_value,pd.maintain_metal_as,pd.payment_days from purchase p,purchasedetails pd where p.supplier_id=?  and pd.last_payment_date>? and p.date<=? and pd.txn_id=p.txn_id");
	define("GET_CURRENT_PURCHASE_METAL_VALUES_BY_DATE","select p.date, pd.maintain_metal_value,pd.maintain_metal_as,pd.payment_days from purchase p,purchasedetails pd where p.supplier_id=? and pd.last_payment_date>=? and pd.txn_id=p.txn_id");
	define("GET_PURCHASE_MC_VALUES_BY_DATE_RANGE","select sum(pd.maintain_mc_value),pd.maintain_mc_as from purchase p,purchasedetails pd where p.supplier_id=? and pd.last_payment_date<=? and pd.txn_id=p.txn_id group by pd.maintain_mc_as");
	define("GET_PURCHASE_METAL_VALUES_BY_DATE_RANGE","select sum(pd.maintain_metal_value),pd.maintain_metal_as from purchase p,purchasedetails pd where p.supplier_id=? and pd.last_payment_date<=? and pd.txn_id=p.txn_id group by pd.maintain_metal_as");
	define("GET_COMPLETE_PURCHASE_MC_VALUES_BY_DATE","select sum(pd.maintain_mc_value),pd.maintain_mc_as from purchase p,purchasedetails pd where p.supplier_id=? and p.date<? and pd.txn_id=p.txn_id group by pd.maintain_mc_as");
	define("GET_COMPLETE_PURCHASE_METAL_VALUES_BY_DATE","select sum(pd.maintain_metal_value),pd.maintain_metal_as from purchase p,purchasedetails pd where p.supplier_id=? and p.date<? and pd.txn_id=p.txn_id group by pd.maintain_metal_as");
	define("GET_PURCHASEDETAILS_BY_DATE_RANGE","select p.date,p.supplier_id,p.billno, pd.* from purchasedetails pd,purchase p where p.supplier_id=? and (pd.last_payment_date>=? and p.date<?) and p.txn_id=pd.txn_id order by p.date");
	define("GET_COMPLETE_PURCHASEDETAILS_BY_DATE_RANGE","select p.date,p.supplier_id,p.billno, pd.* from purchasedetails pd,purchase p where p.supplier_id=? and (p.date>=? and p.date<=?) and p.txn_id=pd.txn_id order by p.date");
	define("GET_PURCHASEDETAILS_INFO","select * from purchasedetails where txn_id=? order  by purchase_details_id ");
	define("ADD_PURCHASEDETAILS_INFO","insert into purchasedetails values (null,?,?,?,?,?,?,?,?,?,?,?,?,?,?)");
	define("MODIFY_PURCHASEDETAILS_INFO","update purchasedetails set (txn_id=?,group_id=?,item_id=?,subitem_id=?,gwt=?,nwt=?,24ctpure=?,maintain_metal_as=?,maintain_metal_value=?,maintain_mc_as=?,maintain_mc_value=?,payment_days=?,last_payment_date=?)");
	define("MODIFY_PURCHASEDETAILS_BY_PURCHASEDETAILID","update purchasedetails set payment_days=?,last_payment_date=? where purchase_details_id=?");
	define("DELETE_PURCHASEDETAILS_INFO","delete from purchasedetails where txn_id=?");
	define("DOES_SUBITEM_HAS_TRANSACTION","select * from purchasedetails where subitem_id=?");
	
	
	/*
	 * Purchase Constants
	 * 
	 */
	
	define("GET_PURCHASE_INFO","select * from purchase where supplier_id=? and billno=?");
	define("ADD_PURCHASE_INFO","insert into purchase values (null,?,?,?)");
	define("MODIFY_PURCHASE_INFO","update purchase set (txn_id=?,date=?,supplier_id=?,billno=?)");
	define("DELETE_PURCHASE_INFO","delete from purchase where txn_id=?");
	define("DOES_BILLNO_EXISTS","select * from purchase where supplier_id=? and billno=?");
	define("GET_DATEWISE_PURCHASE","select * from purchase where date=?");
	
	/*
	 * Inout Entry
	 */
	
	define("GET_ALL_INOUTENTRIES","select * from inoutentry");
	define("GET_INOUTENTRY_INFO","select * from inoutentry where inout_id=?");
	define("ADD_INOUTENTRY_INFO","insert into inoutentry values (null,date(now()),?,?,?,?,?)");
	define("MODIFY_INOUTENTRY_INFO","update inoutentry set (inout_id=?,date=?,issuer_id=?,bearer_id=?,receiver_id=?,location_id=?,type=?)");
	define("DELETE_INOUTENTRY_INFO","delete from inoutentry where inout_id=?");
	define("GET_INOUT_INVENTORY","select iod1.subitem_id,sum(iod1.pcs) from inoutdetails iod1 where iod1.inout_id IN (SELECT inout_id FROM `inoutentry` WHERE date=? and UPPER(type)=?) group by iod1.subitem_id");
	define("GET_OPENING_INOUT_INVENTORY","select iod.subitem_id,sum(iod.pcs) from inoutdetails iod where iod.inout_id IN (select inout_id from inoutentry where date>=? and date <? and UPPER(type)=?) group by iod.subitem_id");
	
	/*
	 * Inout Details
	 */
	define("GET_INOUTDETAILS_INFO","select * from inoutdetails where inout_id=?");
	define("ADD_INOUTDETAILS_INFO","insert into inoutdetails values (null,?,?,?,?,?,?,?,?,?)");
	define("MODIFY_INOUTDETAILS_INFO","update inoutdetails set (inoutdetails_id=?,inout_id=?,group_id=?,item_id=?,subitem_id=?,pcs=?,gwt=?,nwt=?,ctpure=?,amount=?)");
	define("DELETE_INOUTDETAILS_INFO","delete from inoutdetails where inout_id=?");
	
	/*
	* SUSPENSEENTRY CONSTANTS
	*/
	define("GET_SUSPENSE_BALANCE","select sum(sd.nwt),sum(sd.amount),sd.type from suspensedetails sd where sd.suspense_id IN (select se1.suspense_id from suspenseentry se1 where se1.type='OUT' and se1.date>=? and se1.date<=date(now()) and se1.suspense_id NOT IN (select se2.ref_suspense_id from suspenseentry se2)) group by sd.type");
	define("GET_UNRETURNED_SUSPENSEENTRY_INFO","SELECT se1.* FROM suspenseentry se1 where se1.date= date(now()) and se1.type='OUT' AND UPPER(se1.mode) <> 'HALLMARK' and se1.suspense_id NOT IN (select se2.ref_suspense_id from suspenseentry se2);");
	define("GET_SUSPENSEENTRY_RETURN","select * from suspenseentry where ref_suspense_id=? and type='RETURN'");
	define("GET_OUT_SUSPENSEENTRY","select * from suspenseentry where suspense_id=? and type='OUT'");
	define("GET_SUSPENSEENTRY_INFO","select * from suspenseentry where suspense_id=?");
	define("ADD_SUSPENSEENTRY_INFO","insert into suspenseentry values (null,date(now()),?,?,?,?,?,?,?)");
	define("MODIFY_SUSPENSEENTRY_INFO","update suspenseentry set (suspense_id=?,date=?,issuer_id=?,bearer_id=?,receiver_id=?,location_id=?,type=?,mode=?)");
	define("DELETE_SUSPENSEENTRY_INFO","delete from suspenseentry where suspense_id=?");
	
	
	/*
	* SUSPENSEDETAILS CONSTANTS
	*/

	define("GET_SUSPENSEDETAILS_LINEITEM","select * from suspensedetails where suspense_id=? and subitem_id=? limit 1");
	define("GET_SUSPENSEDETAILS_INFO","select * from suspensedetails where suspense_id=? order by suspensedetails_id");
	define("ADD_SUSPENSEDETAILS_INFO","insert into suspensedetails values (null,?,?,?,?,?,?,?,?,?,?)");
	define("MODIFY_SUSPENSEDETAILS_INFO","update suspensedetails set (suspensedetails_id=?,suspense_id=?,group_id=?,item_id=?,subitem_id=?,pcs=?,gwt=?,nwt=?,ctpure=?,amount=?)");
	define("DELETE_SUSPENSEDETAILS_INFO","delete from suspensedetails where suspense_id=?");
	
	/*
	 * PROJECTION CONSTANTS
	 */
	
	define("GET_TODAYS_PROJECTIONS","select * from projection where date=date(now())");
	define("GET_PROJECTIONS_BY_DATE","select * from projection where date=?");
	
	define("GET_PROJECTION_INCOMING_BY_DATE","select txn_id,date,type,category_id,acchead_id, sum(pg),sum(lpg),sum(silver),sum(cash),description from projection where type='incoming' and date=? group by acchead_id");
//	define("GET_PROJECTION_INCOMING_BY_DATE","select *  from projection where type='incoming' and date=? group by");
	define("GET_PROJECTION_OUTGOING_BY_DATE","select txn_id,date,type,category_id,acchead_id, sum(pg),sum(lpg),sum(silver),sum(cash),description from projection where type='outgoing' and date=? group by acchead_id");
//	define("GET_PROJECTION_OUTGOING_BY_DATE","select * from projection where type='outgoing' and date=?");
	define("GET_PROJECTION_INCOMING_BY_DATE_RANGE","select sum(pg),sum(lpg),sum(silver),sum(cash)  from projection where type='incoming' and date>=? and date<?");
	define("GET_PROJECTION_OUTGOING_BY_DATE_RANGE","select sum(pg),sum(lpg),sum(silver),sum(cash)  from projection where type='outgoing' and date>=? and date<?");
	define("GET_PROJECTIONS_BY_ID","select * from projection where txn_id=?");
	define("GET_PROJECTIONS_BY_ACCHEADID","select * from projection where acchead_id=?");
	define("ADD_PROJECTION_INFO","insert into projection values (null,?,?,?,?,?,?,?,?,?)");
	define("MODIFY_PROJECTION_INFO","update projection set date=?,pg=?,lpg=?,silver=?,cash=?,description=? where txn_id=?");
	define("DELETE_PROJECTION_INFO","delete from projection where txn_id=?");
	
	/*
	* NEWARRIVAL CONSTANTS
	*/

	define("GET_NEWARRIVAL_INFO","select * from newarrival where  newarrival_id=?");
	define("ADD_NEWARRIVAL_INFO","insert into newarrival values (null,?,?)");
	define("MODIFY_NEWARRIVAL_INFO","update newarrival set (newarrival_id=?,date=?,supplier_id=?)");
	define("DELETE_NEWARRIVAL_INFO","delete from newarrival where newarrival_id=?");
	
	
	/*
	* NEWARRIVALDETAILS CONSTANTS
	*/

	define("GET_NEWARRIVALDETAILS_INFO","select * from newarrivaldetails where 	newarrival_id=?");
	define("ADD_NEWARRIVALDETAILS_INFO","insert into newarrivaldetails values (null,?,?,?,?,?,?,?,?,?,?,?,?,?)");
	define("MODIFY_NEWARRIVALDETAILS_INFO","update newarrivaldetails set (newarrival_details_id=?,newarrival_id=?,group_id=?,item_id=?,subitem_id=?,gms=?,pcs=?,size=?,mc=?,stone=?,total_amount=?,due_date=?,no_of_days=?,description=?)");
	define("DELETE_NEWARRIVALDETAILS_INFO","delete from newarrivaldetails where id=?");
	
	
	/*
	* REQUIREMENTS CONSTANTS
	*/

	define("GET_REQUIREMENTS_INFO","select * from requirements where requirements_id=?");
	define("ADD_REQUIREMENTS_INFO","insert into requirements values (null,?,?)");
	define("MODIFY_REQUIREMENTS_INFO","update requirements set (requirements_id=?,date=?,employee_id=?)");
	define("DELETE_REQUIREMENTS_INFO","delete from requirements where requirements_id=?");
	
	
	/*
	* REQUIREMENTDETAILS CONSTANTS
	*/

	define("GET_REQUIREMENTDETAILS_INFO","select * from requirementdetails where requirements_id=?");
	define("ADD_REQUIREMENTDETAILS_INFO","insert into requirementdetails values (null,?,?,?,?,?,?,?,?,?,?,?,?,?)");
	define("MODIFY_REQUIREMENTDETAILS_INFO","update requirementdetails set (requirements_details_id=?,requirements_id=?,group_id=?,item_id=?,subitem_id=?,gms=?,pcs=?,size=?,mc=?,stone=?,total_amount=?,due_date=?,no_of_days=?,description=?)");
	define("DELETE_REQUIREMENTDETAILS_INFO","delete from requirementdetails where requirements_id=?");
	
?>
