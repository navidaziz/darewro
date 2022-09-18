
public class PostEditActivity extends AppCompatActivity {
	
	private text post_title;
				private text post_summary;
				private text post_detail;
				private EditText post_type;
				private EditText image;
				private EditText video_link;
				private text post_keywords;
				private Button btn_update_posts;
	
	@Override
    protected void onCreate(Bundle savedInstanceState) {
        super.onCreate(savedInstanceState);
        this.requestWindowFeature(Window.FEATURE_NO_TITLE);
        setContentView(R.layout.activity_edit_post);
		
		post_title = (text)findViewById(R.id.post_title);
				post_summary = (text)findViewById(R.id.post_summary);
				post_detail = (text)findViewById(R.id.post_detail);
				post_type = (EditText)findViewById(R.id.post_type);
				image = (EditText)findViewById(R.id.image);
				video_link = (EditText)findViewById(R.id.video_link);
				post_keywords = (text)findViewById(R.id.post_keywords);
				btn_edit_posts = (Button)findViewById(R.id.btn_update_posts);
		
		
		
		Intent intent = getIntent();
		String id = intent.getStringExtra("id");
		
		RequestQueue request_queue = Volley.newRequestQueue(PostEditActivity.this);
		StringRequest request = new StringRequest(Request.Method.POST, SERVER_URL+"/mobile/post/view_post/"+id, new Response.Listener<String>() {
								@Override
								public void onResponse(String server_response) {
								try {
                    			JSONArray JsonArray = new JSONArray(server_response);
								for(int i=0; i<=JsonArray.length(); i++){
									JSONObject json_object = JsonArray.getJSONObject(i);
									post_title.setText(json_object.getString("post_title"));
				post_summary.setText(json_object.getString("post_summary"));
				post_detail.setText(json_object.getString("post_detail"));
				post_type.setText(json_object.getString("post_type"));
				image.setText(json_object.getString("image"));
				video_link.setText(json_object.getString("video_link"));
				post_keywords.setText(json_object.getString("post_keywords"));
				
			
								}
			
			
							} catch (JSONException e) {
								e.printStackTrace();
							 //   Toast.makeText(MainActivity.this, "error", Toast.LENGTH_SHORT).show();
							}
								}
							}, new Response.ErrorListener() {
								@Override
								public void onErrorResponse(VolleyError volleyError) {
								Toast.makeText(PostAddActivity.this, volleyError.toString(), Toast.LENGTH_SHORT).show();
								}
							}){
								@Override
								protected Map<String, String> getParams()  {
									HashMap<String,String> params = new HashMap<String,String>();
									return params;
								}
							};
							
				 request_queue.add(request);



	
btn_update_posts.setOnClickListener(new View.OnClickListener() {
            @Override
            public void onClick(View v) {
              final String form_post_title = post_title.getText().toString();
				final String form_post_summary = post_summary.getText().toString();
				final String form_post_detail = post_detail.getText().toString();
				final String form_post_type = post_type.getText().toString();
				final String form_image = image.getText().toString();
				final String form_video_link = video_link.getText().toString();
				final String form_post_keywords = post_keywords.getText().toString();
				
				
				RequestQueue request_queue = Volley.newRequestQueue(PostAddActivity.this); 
				 StringRequest request = new StringRequest(Request.Method.POST, url+"/mobile/post/save_data/"+form_post_id, new Response.Listener<String>() {
								@Override
								public void onResponse(String server_response) {
								Toast.makeText(PostAddActivity.this, server_response, Toast.LENGTH_SHORT).show();
								}
							}, new Response.ErrorListener() {
								@Override
								public void onErrorResponse(VolleyError volleyError) {
								Toast.makeText(PostAddActivity.this, volleyError.toString(), Toast.LENGTH_SHORT).show();
								}
							}){
								@Override
								protected Map<String, String> getParams()  {
									HashMap<String,String> params = new HashMap<String,String>();
									params.put("post_title", form_post_title);
				params.put("post_summary", form_post_summary);
				params.put("post_detail", form_post_detail);
				params.put("post_type", form_post_type);
				params.put("image", form_image);
				params.put("video_link", form_video_link);
				params.put("post_keywords", form_post_keywords);
				
									return params;
								}
							};
							
				 request_queue.add(request);
				
				
            }
        });
//end here .....
		
		
        
    }

}
